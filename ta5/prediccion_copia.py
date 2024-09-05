import mysql.connector
from sklearn.linear_model import LinearRegression
import numpy as np

# Conexión a la base de datos
conn = mysql.connector.connect(
    host='localhost',
    user='root',
    password='',
    database='ta'
)
cursor = conn.cursor()

# Obtener los datos de las tablas
cursor.execute("SELECT dui, sistole, diastole FROM tmptension ORDER BY dui DESC LIMIT 10")
tension_data = cursor.fetchall()

cursor.execute("SELECT dui, historia, obesidad, sedentarismo, alcoholismo, tabaquismo, diabetes, colesterol FROM tmpfactores")
factores_data = cursor.fetchall()

# Convertir los datos a arrays de numpy y asegurarse de que sean numéricos
tension_array = np.array(tension_data, dtype=float)
factores_array = np.array(factores_data, dtype=float)

# Crear un diccionario para mapear dui a factores
factores_dict = {row[0]: row[1:] for row in factores_array}

# Filtrar y alinear los datos
aligned_data = [(t[0], t[1], t[2], *factores_dict[t[0]]) for t in tension_array if t[0] in factores_dict]

# Convertir los datos alineados a arrays de numpy
aligned_array = np.array(aligned_data, dtype=float)

# Separar los datos en variables independientes y dependientes
X = aligned_array[:, 3:]  # Factores de riesgo
y_sistole = aligned_array[:, 1]  # Valores de sistole
y_diastole = aligned_array[:, 2]  # Valores de diastole

# Crear y entrenar el modelo de regresión lineal
model_sistole = LinearRegression().fit(X, y_sistole)
model_diastole = LinearRegression().fit(X, y_diastole)

# Predecir los valores futuros
pred_sistole = model_sistole.predict(X[-1].reshape(1, -1))
pred_diastole = model_diastole.predict(X[-1].reshape(1, -1))

# Convertir los valores predichos a enteros
pred_sistole = int(pred_sistole[0])
pred_diastole = int(pred_diastole[0])
dui = int(aligned_array[-1, 0])

# Insertar los valores predichos en la tabla prediccion
cursor.execute("INSERT INTO prediccion (dui, sistole, diastole) VALUES (%s, %s, %s)", (dui, pred_sistole, pred_diastole))
conn.commit()

# Cerrar la conexión
cursor.close()
conn.close()

#print(f"Predicción insertada para el paciente con DUI {dui}: Sistole={pred_sistole}, Diastole={pred_diastole}")
