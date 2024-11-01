import mysql.connector
from sklearn.metrics import mean_squared_error
import numpy as np  # Asegúrate de importar numpy para usar sqrt

# Conexión a la base de datos MySQL
conexion = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="ta"
)

cursor = conexion.cursor()

# Consulta para obtener los valores de tmptension y predicción por cada paciente (dui)
consulta = """
    SELECT t.dui, t.sistole AS real_sistole, t.diastole AS real_diastole, 
           p.sistole AS pred_sistole, p.diastole AS pred_diastole
    FROM tmptension t
    JOIN prediccion p ON t.dui = p.dui
    ORDER BY t.dui
"""
cursor.execute(consulta)
resultados = cursor.fetchall()

# Diccionario para almacenar los valores de presión arterial por paciente
valores_por_paciente = {}

# Agrupar los valores de sístole y diástole por paciente (dui)
for fila in resultados:
    dui, real_sistole, real_diastole, pred_sistole, pred_diastole = fila
    
    if dui not in valores_por_paciente:
        valores_por_paciente[dui] = {'real_sistole': [], 'real_diastole': [], 'pred_sistole': [], 'pred_diastole': []}
    
    valores_por_paciente[dui]['real_sistole'].append(real_sistole)
    valores_por_paciente[dui]['real_diastole'].append(real_diastole)
    valores_por_paciente[dui]['pred_sistole'].append(pred_sistole)
    valores_por_paciente[dui]['pred_diastole'].append(pred_diastole)

# Diccionario para almacenar los valores de RMSE por paciente
rmse_resultados = {}

# Calcular el RMSE para cada paciente utilizando todos sus valores
for dui, datos in valores_por_paciente.items():
    real_sistole_list = datos['real_sistole']
    pred_sistole_list = datos['pred_sistole']
    real_diastole_list = datos['real_diastole']
    pred_diastole_list = datos['pred_diastole']
    
    # Calcular MSE para sístole y diástole
    mse_sistole = mean_squared_error(real_sistole_list, pred_sistole_list)
    mse_diastole = mean_squared_error(real_diastole_list, pred_diastole_list)
    
    # Calcular RMSE tomando la raíz cuadrada de MSE
    rmse_sistole = np.sqrt(mse_sistole)
    rmse_diastole = np.sqrt(mse_diastole)
    
    # Guardar los resultados
    rmse_resultados[dui] = (float(rmse_sistole), float(rmse_diastole))

# Insertar los valores de RMSE en la tabla tmpmse
for dui, (rmse_sistole, rmse_diastole) in rmse_resultados.items():
    insercion = """
        INSERT INTO tmprmse (dui, rmsesistole, rmsediastole)
        VALUES (%s, %s, %s)
        ON DUPLICATE KEY UPDATE rmsesistole = VALUES(rmsesistole), rmsediastole = VALUES(rmsediastole)
    """
    cursor.execute(insercion, (dui, rmse_sistole, rmse_diastole))

# Confirmar la inserción
conexion.commit()

# Cerrar la conexión
cursor.close()
conexion.close()

print("(RMSE) ")
print("")
