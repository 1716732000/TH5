import mysql.connector
from sklearn.metrics import mean_squared_error

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

# Agrupar los valores de sístole y diastole por paciente (dui)
for fila in resultados:
    dui, real_sistole, real_diastole, pred_sistole, pred_diastole = fila
    
    if dui not in valores_por_paciente:
        valores_por_paciente[dui] = {'real_sistole': [], 'real_diastole': [], 'pred_sistole': [], 'pred_diastole': []}
    
    valores_por_paciente[dui]['real_sistole'].append(real_sistole)
    valores_por_paciente[dui]['real_diastole'].append(real_diastole)
    valores_por_paciente[dui]['pred_sistole'].append(pred_sistole)
    valores_por_paciente[dui]['pred_diastole'].append(pred_diastole)

# Diccionario para almacenar los valores de MSE por paciente
mse_resultados = {}

# Calcular el MSE para cada paciente utilizando todos sus valores
for dui, datos in valores_por_paciente.items():
    real_sistole_list = datos['real_sistole']
    pred_sistole_list = datos['pred_sistole']
    real_diastole_list = datos['real_diastole']
    pred_diastole_list = datos['pred_diastole']
    
    # Depurar: Imprimir los valores reales y predichos para revisar diferencias
    #print(f"DUi: {dui}")
    #print(f"Real Sistole: {real_sistole_list}")
    #print(f"Pred Sistole: {pred_sistole_list}")
    #print(f"Real Diastole: {real_diastole_list}")
    #print(f"Pred Diastole: {pred_diastole_list}")
    #print("-" * 40)
    
    # Calcular MSE para sistole y diastole en base a múltiples muestras
    mse_sistole = mean_squared_error(real_sistole_list, pred_sistole_list)
    mse_diastole = mean_squared_error(real_diastole_list, pred_diastole_list)
    
    # Guardar los resultados
    mse_resultados[dui] = (float(mse_sistole), float(mse_diastole))

# Insertar los valores de MSE en la tabla tmpmse
for dui, (mse_sistole, mse_diastole) in mse_resultados.items():
    insercion = """
        INSERT INTO tmpmse (dui, msesistole, msediastole)
        VALUES (%s, %s, %s)
        ON DUPLICATE KEY UPDATE msesistole = VALUES(msesistole), msediastole = VALUES(msediastole)
    """
    cursor.execute(insercion, (dui, mse_sistole, mse_diastole))

# Confirmar la inserción
conexion.commit()

# Cerrar la conexión
cursor.close()
conexion.close()

print("(MSE) ")
print("")
