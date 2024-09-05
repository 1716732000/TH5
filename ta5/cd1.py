import mysql.connector
import numpy as np
from sklearn.metrics import r2_score

# Conexión a la base de datos MySQL
conexion = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="ta"
)

# Crear un cursor para ejecutar consultas
cursor = conexion.cursor()

# Consulta para obtener el DUI del único registro en tmppaciente
cursor.execute("SELECT dui FROM tmppaciente LIMIT 1")
dui = cursor.fetchone()[0]

# Consulta para obtener los datos de sistole y diastole
cursor.execute("SELECT sistole, diastole FROM tmptension")
datos = cursor.fetchall()

# Separar los datos de sistole y diastole
y_true_sistole = np.array([fila[0] for fila in datos])
y_true_diastole = np.array([fila[1] for fila in datos])

# Simulación de valores predichos (en un caso real, estos vendrían de tu modelo)
y_pred_sistole = y_true_sistole + np.random.normal(0, 2, len(y_true_sistole))  # Añadimos un pequeño ruido
y_pred_diastole = y_true_diastole + np.random.normal(0, 2, len(y_true_diastole))

# Calcular el coeficiente de determinación R^2 para sistole y diastole
r2_sistole = r2_score(y_true_sistole, y_pred_sistole)
r2_diastole = r2_score(y_true_diastole, y_pred_diastole)

# Imprimir en consola los valores Coeficiente de Determinación R^2
# print(f"Coeficiente de determinación R^2 para sístole: {r2_sistole:.3f}")

# print(f"Coeficiente de determinación R^2 para diástole: {r2_diastole:.3f}")

# Insertar los valores en la tabla tmpcd
insertar_sql = """
INSERT INTO tmpcd (dui, cdsistole, cddiastole)
VALUES (%s, %s, %s)
"""
valores = (dui, r2_sistole, r2_diastole)

cursor.execute(insertar_sql, valores)
conexion.commit()

# Cerrar el cursor y la conexión
cursor.close()
conexion.close()
