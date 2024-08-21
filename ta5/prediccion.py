import mysql.connector
from mysql.connector import Error
from sklearn.linear_model import LinearRegression
import numpy as np

def connect_to_db():
    try:
        connection = mysql.connector.connect(
            host='localhost',
            database='ta',
            user='root',
            password=''
        )
        if connection.is_connected():
            print(" ")
        return connection
    except Error as e:
        print("Error while connecting to MySQL", e)
        return None

def get_last_10_values(connection):
    query = """
    SELECT dui, sistole, diastole FROM tmptension 
    ORDER BY ingreso DESC
    LIMIT 10
    """
    cursor = connection.cursor()
    cursor.execute(query)
    rows = cursor.fetchall()
    return rows

def prepare_data_for_prediction(rows):
    X = np.arange(1, len(rows) + 1).reshape(-1, 1)  # Valores de tiempo (1, 2, ..., 10)
    y_sistole = np.array([row[1] for row in rows])  # Valores de sistole
    y_diastole = np.array([row[2] for row in rows])  # Valores de diastole
    return X, y_sistole, y_diastole

def predict_next_values(X, y_sistole, y_diastole):
    model_sistole = LinearRegression()
    model_diastole = LinearRegression()
    
    model_sistole.fit(X, y_sistole)
    model_diastole.fit(X, y_diastole)
    
    next_time = np.array([[len(X) + 1]])  # Predecir el siguiente valor de tiempo (11)
    predicted_sistole = model_sistole.predict(next_time)[0]
    predicted_diastole = model_diastole.predict(next_time)[0]
    
    return predicted_sistole, predicted_diastole

def insert_predictions(connection, dui, predicted_sistole, predicted_diastole):
    cursor = connection.cursor()
    insert_query = """
    INSERT INTO prediccion (dui, sistole, diastole) 
    VALUES (%s, %s, %s)
    """
    cursor.execute(insert_query, (dui, float(predicted_sistole), float(predicted_diastole)))
    connection.commit()

def main():
    connection = connect_to_db()
    if connection:
        rows = get_last_10_values(connection)
        if rows:
            dui = rows[0][0]
            X, y_sistole, y_diastole = prepare_data_for_prediction(rows)
            predicted_sistole, predicted_diastole = predict_next_values(X, y_sistole, y_diastole)
            insert_predictions(connection, dui, predicted_sistole, predicted_diastole)
        connection.close()

if __name__ == "__main__":
    main()
