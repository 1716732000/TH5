import mysql.connector
import numpy as np
from sklearn.metrics import r2_score

def conectar_bd():
    """Conecta a la base de datos y devuelve la conexión y el cursor."""
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
    """Obtiene los DUI de todos los pacientes en la tabla tmppaciente."""
    cursor.execute("SELECT dui FROM tmppaciente")
    return cursor.fetchall()

def obtener_datos_tension(cursor, dui):
    """Obtiene los datos de sístole y diástole de un paciente específico."""
    cursor.execute(f"SELECT sistole, diastole FROM tmptension WHERE dui = %s", (dui,))
    return cursor.fetchall()

def calcular_r2(y_true, y_pred):
    """Calcula el coeficiente de determinación R^2."""
    return r2_score(y_true, y_pred)

def predecir_tension(y_true_sistole, y_true_diastole):
    """
    Genera predicciones basadas en el modelo que se esté utilizando.
    Aquí puedes reemplazarlo con el modelo que prefieras (MLP, Random Forest, etc.).
    """
    # Simulación de predicciones con ruido, reemplazar con un modelo real
    y_pred_sistole = y_true_sistole + np.random.normal(0, 2, len(y_true_sistole))
    y_pred_diastole = y_true_diastole + np.random.normal(0, 2, len(y_true_diastole))
    return y_pred_sistole, y_pred_diastole

def insertar_resultados(cursor, dui, r2_sistole, r2_diastole):
    """Inserta los resultados de R^2 en las tablas tmpcd y tmpr2."""
    insertar_tmpcd_sql = """
    INSERT INTO tmpcd (dui, cdsistole, cddiastole)
    VALUES (%s, %s, %s)
    """
    insertar_tmpr2_sql = """
    INSERT INTO tmpr2 (dui, r2sistole, r2diastole)
    VALUES (%s, %s, %s)
    """
    valores = (dui, r2_sistole, r2_diastole)

    # Inserta en la tabla tmpcd
    cursor.execute(insertar_tmpcd_sql, valores)

    # Inserta en la tabla tmpr2
    cursor.execute(insertar_tmpr2_sql, valores)

def procesar_paciente(cursor, dui):
    """Procesa un paciente: obtiene datos, predice y almacena resultados."""
    datos = obtener_datos_tension(cursor, dui)
    
    if not datos:
        print(f"No se encontraron datos de tensión para el paciente con DUI {dui}")
        return

    # Separar los datos de sístole y diástole
    y_true_sistole = np.array([fila[0] for fila in datos])
    y_true_diastole = np.array([fila[1] for fila in datos])

    # Predicción usando un modelo real (aquí simulado con ruido)
    y_pred_sistole, y_pred_diastole = predecir_tension(y_true_sistole, y_true_diastole)

    # Calcular R^2
    r2_sistole = calcular_r2(y_true_sistole, y_pred_sistole)
    r2_diastole = calcular_r2(y_true_diastole, y_pred_diastole)

    # Insertar los resultados en la base de datos
    insertar_resultados(cursor, dui, r2_sistole, r2_diastole)

    #print(f"Procesado paciente con DUI {dui}: R² sístole = {r2_sistole:.3f}, R² diástole = {r2_diastole:.3f}")

def main():
    # Conexión a la base de datos
    conexion, cursor = conectar_bd()
    if not conexion or not cursor:
        return

    try:
        # Obtener todos los pacientes
        pacientes = obtener_pacientes(cursor)

        if not pacientes:
            print("No se encontraron pacientes en la tabla.")
            return

        # Procesar cada paciente
        for paciente in pacientes:
            dui = paciente[0]
            procesar_paciente(cursor, dui)

        # Confirmar cambios en la base de datos
        conexion.commit()

    except Exception as e:
        print(f"Error durante la ejecución: {e}")
    finally:
        # Cerrar el cursor y la conexión
        cursor.close()
        conexion.close()

    print("(R2) ")
    print("")

if __name__ == "__main__":
    main()
