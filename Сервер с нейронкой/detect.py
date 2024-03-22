def load_data():
    dataf = pd.read_csv(
        '/var/www/www-root/data/www/наш_домен/labeled_data.csv'
    )
    trains_text, tests_text, trains_labels, tests_labels = train_test_split(
        dataf['message'],
        dataf['class'],
        test_size=0.2
    )

    return trains_text, tests_text, trains_labels, tests_labels

def tokenize_data(trained_text, tested_text):
    tokenizer_data = Tokenizer(
        num_words=5000
    )
    tokenizer_data.fit_on_texts(
        trained_text
    )
    trained_sequences = pad_sequences(
        tokenizer_data.texts_to_sequences(trained_text),
        maxlen=100
    )
    tested_sequences = pad_sequences(
        tokenizer_data.texts_to_sequences(tested_text),
        maxlen=100
    )

    return tokenizer_data


import tensorflow as tf
from tensorflow import keras
import pandas as pd
from sklearn.model_selection import train_test_split
from tensorflow.keras.preprocessing.text import Tokenizer
from tensorflow.keras.preprocessing.sequence import pad_sequences
new_model = tf.keras.models.load_model('/var/www/www-root/data/www/itcollabhubmlmodel.ru/ai_detection_model.h5')
train_text, test_text, train_labels, test_labels = load_data()
tokenizer = tokenize_data(train_text, test_text)

def classify_input(user_input):
    sequence = pad_sequences(
        tokenizer.texts_to_sequences([user_input]), 
        maxlen=100
    )
    prediction = new_model.predict(sequence)[0][0]

    return(str(prediction))

