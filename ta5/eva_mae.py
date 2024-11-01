import mysql.connector
from sklearn.metrics import mean_absolute_error  # Importar MAE
import numpy as np  # Asegúrate de importar numpy si lo necesitas para otras operaciones

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

# Diccionario para almacenar los valores de MAE por paciente
mae_resultados = {}

# Calcular el MAE para cada paciente utilizando todos sus valores
for dui, datos in valores_por_paciente.items():
    real_sistole_list = datos['real_sistole']
    pred_sistole_list = datos['pred_sistole']
    real_diastole_list = datos['real_diastole']
    pred_diastole_list = datos['pred_diastole']
    
    # Calcular MAE para sístole y diástole
    mae_sistole = mean_absolute_error(real_sistole_list, pred_sistole_list)
    mae_diastole = mean_absolute_error(real_diastole_list, pred_diastole_list)
    
    # Guardar los resultados
    mae_resultados[dui] = (float(mae_sistole), float(mae_diastole))

# Insertar los valores de MAE en la tabla tmpmae
for dui, (mae_sistole, mae_diastole) in mae_resultados.items():
    insercion = """
        INSERT INTO tmpmae (dui, maesistole, maediastole)
        VALUES (%s, %s, %s)
        ON DUPLICATE KEY UPDATE maesistole = VALUES(maesistole), maediastole = VALUES(maediastole)
    """
    cursor.execute(insercion, (dui, mae_sistole, mae_diastole))

# Confirmar la inserción
conexion.commit()

# Cerrar la conexión
cursor.close()
conexion.close()

print("(MAE) ")
print("")
