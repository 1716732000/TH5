import mysql.connector
import numpy as np
from sklearn.ensemble import RandomForestRegressor
from sklearn.metrics import r2_score
from sklearn.model_selection import train_test_split
import pickle

def conectar_bd():
    """
    Conecta a la base de datos MySQL y devuelve la conexión y el cursor.
    Maneja posibles errores de conexión.
    """
    try:
        conexion = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="ta"
        )
        return conexion, conexion.cursor()
    except mysql.connector.Error as err:
        print(f"Error al conectar con la base de datos: {err}")
        return None, None

def obtener_pacientes(cursor):
    """
    Obtiene los DUI de todos los pacientes registrados en la tabla 'tmppaciente'.
    """
    cursor.execute("SELECT dui FROM tmppaciente")
    return cursor.fetchall()

def obtener_datos_tension(cursor, dui):
    """
    Recupera los datos de presión arterial (sístole y diástole) de la tabla 'tmptension' 
    para un paciente específico, identificado por su DUI.
    """
    cursor.execute("SELECT sistole, diastole FROM tmptension WHERE dui = %s", (dui,))
    return cursor.fetchall()

def predecir_tension(model_sistole, model_diastole, factores_riesgo):
    """
    Genera predicciones basadas en el modelo de Random Forest entrenado.
    
    Args:
        model_sistole (RandomForestRegressor): Modelo entrenado para sístole.
        model_diastole (RandomForestRegressor): Modelo entrenado para diástole.
        factores_riesgo (array): Factores de riesgo para hacer la predicción.
        
    Returns:
        tuple: Predicciones para sístole y diástole.
    """
    # Predecir la tensión arterial usando los factores de riesgo
    y_pred_sistole = model_sistole.predict([factores_riesgo])
    y_pred_diastole = model_diastole.predict([factores_riesgo])
    
    return y_pred_sistole[0], y_pred_diastole[0]

def insertar_resultados(cursor, dui, r2_sistole, r2_diastole):
    """
    Inserta los resultados del coeficiente de determinación R^2 en la tabla 'tmpcd'
    para un paciente específico identificado por su DUI.
    """
    insertar_sql = """
    INSERT INTO tmpcd (dui, cdsistole, cddiastole)
    VALUES (%s, %s, %s)
    """
    valores = (dui, r2_sistole, r2_diastole)
    cursor.execute(insertar_sql, valores)

def entrenar_modelo(cursor):
    """
    Entrena modelos de predicción (Random Forest) para sístole y diástole usando datos históricos.
    
    Returns:
        tuple: Modelos entrenados para sístole y diástole.
    """
    # Obtener datos históricos de presión arterial y factores de riesgo
    cursor.execute("SELECT sistole, diastole, factor1, factor2, factor3 FROM tmpfactores")
    datos = cursor.fetchall()
    
    # Separar las variables independientes (factores de riesgo) y dependientes (sístole y diástole)
    X = np.array([fila[2:] for fila in datos])  # Factores de riesgo
    y_sistole = np.array([fila[0] for fila in datos])  # Valores de sístole
    y_diastole = np.array([fila[1] for fila in datos])  # Valores de diástole

    # Dividir el conjunto de datos en entrenamiento y prueba
    X_train, X_test, y_sistole_train, y_sistole_test = train_test_split(X, y_sistole, test_size=0.2, random_state=42)
    X_train, X_test, y_diastole_train, y_diastole_test = train_test_split(X, y_diastole, test_size=0.2, random_state=42)

    # Entrenar modelos de Random Forest
    model_sistole = RandomForestRegressor(n_estimators=100, random_state=42)
    model_sistole.fit(X_train, y_sistole_train)

    model_diastole = RandomForestRegressor(n_estimators=100, random_state=42)
    model_diastole.fit(X_train, y_diastole_train)

    # Opcional: Guardar los modelos en archivos para usarlos más tarde
    with open('model_sistole.pkl', 'wb') as f:
        pickle.dump(model_sistole, f)
    with open('model_diastole.pkl', 'wb') as f:
        pickle.dump(model_diastole, f)

    return model_sistole, model_diastole

def procesar_paciente(cursor, dui, model_sistole, model_diastole):
    """
    Procesa un paciente: obtiene sus datos de presión arterial, genera predicciones,
    calcula el coeficiente R^2 y guarda los resultados en la base de datos.
    """
    datos = obtener_datos_tension(cursor, dui)
    
    if not datos:
        print(f"No se encontraron datos de tensión para el paciente con DUI {dui}")
        return

    # Obtener factores de riesgo del paciente
    cursor.execute("SELECT factor1, factor2, factor3 FROM tmpfactores WHERE dui = %s", (dui,))
    factores_riesgo = cursor.fetchone()

    # Predicción usando el modelo de Random Forest
    y_pred_sistole, y_pred_diastole = predecir_tension(model_sistole, model_diastole, factores_riesgo)

    # Separar los datos reales de sístole y diástole
    y_true_sistole = np.array([fila[0] for fila in datos])
    y_true_diastole = np.array([fila[1] for fila in datos])

    # Calcular R^2
    r2_sistole = calcular_r2(y_true_sistole, [y_pred_sistole] * len(y_true_sistole))
    r2_diastole = calcular_r2(y_true_diastole, [y_pred_diastole] * len(y_true_diastole))

    # Insertar los resultados en la base de datos
    insertar_resultados(cursor, dui, r2_sistole, r2_diastole)

    print(f"Procesado paciente con DUI {dui}: R² sístole = {r2_sistole:.3f}, R² diástole = {r2_diastole:.3f}")

def main():
    """
    Función principal que ejecuta el flujo completo del programa:
    1. Conecta a la base de datos.
    2. Entrena los modelos de predicción.
    3. Procesa cada paciente para calcular y almacenar los coeficientes R^2.
    4. Cierra la conexión con la base de datos.
    """
    # Conectar a la base de datos
    conexion, cursor = conectar_bd()
    if not conexion or not cursor:
        return

    try:
        # Entrenar los modelos de predicción
        model_sistole, model_diastole = entrenar_modelo(cursor)

        # Obtener la lista de pacientes
        pacientes = obtener_pacientes(cursor)

        if not pacientes:
            print("No se encontraron pacientes en la tabla.")
            return

        # Procesar cada paciente
        for paciente in pacientes:
            dui = paciente[0]
            procesar_paciente(cursor, dui, model_sistole, model_diastole)

        # Confirmar los cambios en la base de datos
        conexion.commit()

    except Exception as e:
        print(f"Error durante la ejecución: {e}")
    finally:
        # Cerrar el cursor y la conexión con la base de datos
        cursor.close()
        conexion.close()

if __name__ == "__main__":
    main()
