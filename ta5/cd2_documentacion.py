import mysql.connector
import numpy as np
from sklearn.metrics import r2_score

def conectar_bd():
    """
    Conecta a la base de datos MySQL y devuelve la conexión y el cursor.
    Maneja posibles errores de conexión.

    Returns:
        tuple: (conexion, cursor) si la conexión es exitosa, 
               (None, None) si ocurre un error.
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

    Args:
        cursor (MySQLCursor): El cursor de la base de datos para ejecutar la consulta.

    Returns:
        list: Una lista de tuplas, donde cada tupla contiene el DUI de un paciente.
    """
    cursor.execute("SELECT dui FROM tmppaciente")
    return cursor.fetchall()

def obtener_datos_tension(cursor, dui):
    """
    Recupera los datos de presión arterial (sístole y diástole) de la tabla 'tmptension' 
    para un paciente específico, identificado por su DUI.

    Args:
        cursor (MySQLCursor): El cursor de la base de datos para ejecutar la consulta.
        dui (str): El DUI del paciente para buscar sus datos de presión arterial.

    Returns:
        list: Una lista de tuplas con los valores de sístole y diástole.
    """
    cursor.execute("SELECT sistole, diastole FROM tmptension WHERE dui = %s", (dui,))
    return cursor.fetchall()

def calcular_r2(y_true, y_pred):
    """
    Calcula el coeficiente de determinación R^2 entre los valores verdaderos y predichos.

    Args:
        y_true (array): Los valores reales observados (y_true).
        y_pred (array): Los valores predichos por el modelo (y_pred).

    Returns:
        float: El valor del coeficiente de determinación R^2.
    """
    return r2_score(y_true, y_pred)

def predecir_tension(y_true_sistole, y_true_diastole):
    """
    Genera predicciones de los valores de sístole y diástole, utilizando ruido normal
    para simular predicciones. Este espacio está diseñado para ser reemplazado con 
    un modelo de predicción real (MLP, Random Forest, etc.).

    Args:
        y_true_sistole (array): Valores verdaderos de sístole.
        y_true_diastole (array): Valores verdaderos de diástole.

    Returns:
        tuple: Predicciones para sístole y diástole (y_pred_sistole, y_pred_diastole).
    """
    # Simulación de predicciones con ruido (reemplazar con el modelo real)
    y_pred_sistole = y_true_sistole + np.random.normal(0, 2, len(y_true_sistole))
    y_pred_diastole = y_true_diastole + np.random.normal(0, 2, len(y_true_diastole))
    return y_pred_sistole, y_pred_diastole

def insertar_resultados(cursor, dui, r2_sistole, r2_diastole):
    """
    Inserta los resultados del coeficiente de determinación R^2 en la tabla 'tmpcd'
    para un paciente específico identificado por su DUI.

    Args:
        cursor (MySQLCursor): El cursor de la base de datos para ejecutar la consulta.
        dui (str): El DUI del paciente.
        r2_sistole (float): El coeficiente R^2 para la predicción de sístole.
        r2_diastole (float): El coeficiente R^2 para la predicción de diástole.
    """
    insertar_sql = """
    INSERT INTO tmpcd (dui, cdsistole, cddiastole)
    VALUES (%s, %s, %s)
    """
    valores = (dui, r2_sistole, r2_diastole)
    cursor.execute(insertar_sql, valores)

def procesar_paciente(cursor, dui):
    """
    Procesa un paciente: obtiene sus datos de presión arterial, genera predicciones,
    calcula el coeficiente R^2 y guarda los resultados en la base de datos.

    Args:
        cursor (MySQLCursor): El cursor de la base de datos.
        dui (str): El DUI del paciente.
    """
    # Obtener datos de presión arterial del paciente
    datos = obtener_datos_tension(cursor, dui)
    
    if not datos:
        # Si no se encuentran datos de tensión arterial, se omite este paciente
        print(f"No se encontraron datos de tensión para el paciente con DUI {dui}")
        return

    # Separar los valores de sístole y diástole en arrays
    y_true_sistole = np.array([fila[0] for fila in datos])
    y_true_diastole = np.array([fila[1] for fila in datos])

    # Predicción de valores de sístole y diástole
    y_pred_sistole, y_pred_diastole = predecir_tension(y_true_sistole, y_true_diastole)

    # Calcular el coeficiente R^2 para sístole y diástole
    r2_sistole = calcular_r2(y_true_sistole, y_pred_sistole)
    r2_diastole = calcular_r2(y_true_diastole, y_pred_diastole)

    # Insertar los resultados en la base de datos
    insertar_resultados(cursor, dui, r2_sistole, r2_diastole)

    # Mostrar los resultados por consola
    print(f"Procesado paciente con DUI {dui}: R² sístole = {r2_sistole:.3f}, R² diástole = {r2_diastole:.3f}")

def main():
    """
    Función principal que ejecuta el flujo completo del programa:
    1. Conecta a la base de datos.
    2. Obtiene la lista de pacientes.
    3. Procesa cada paciente para calcular y almacenar los coeficientes R^2.
    4. Cierra la conexión con la base de datos.
    """
    # Conectar a la base de datos
    conexion, cursor = conectar_bd()
    if not conexion or not cursor:
        # Salir si no se pudo establecer la conexión
        return

    try:
        # Obtener la lista de pacientes
        pacientes = obtener_pacientes(cursor)

        if not pacientes:
            print("No se encontraron pacientes en la tabla.")
            return

        # Procesar cada paciente
        for paciente in pacientes:
            dui = paciente[0]
            procesar_paciente(cursor, dui)

        # Confirmar los cambios en la base de datos
        conexion.commit()

    except Exception as e:
        # Manejo de errores en caso de que ocurra alguna excepción
        print(f"Error durante la ejecución: {e}")
    finally:
        # Cerrar el cursor y la conexión con la base de datos
        cursor.close()
        conexion.close()

if __name__ == "__main__":
    main()
