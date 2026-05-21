from fastapi import FastAPI
from pydantic import BaseModel
import pandas as pd
import numpy as np
import joblib

# =========================
# INISIALISASI FASTAPI
# =========================
app = FastAPI(title="SPK Jurusan ML API")

# =========================
# LOAD MODEL & SCALER
# =========================
model = joblib.load("model_jurusan.pkl")
scaler = joblib.load("scaler_jurusan.pkl")

# =========================
# LOAD DATASET
# =========================
data = pd.read_csv("Dataset_Jurusan.csv")

# =========================
# SCHEMA INPUT
# =========================
class JurusanInput(BaseModel):

    nama_siswa: str
    kompetensi: float
    nilai_akademik: float
    jurusan_1: str
    jurusan_2: str


# =========================
# ROOT API
# =========================
@app.get("/")
def root():

    return {
        "message": "API SPK Jurusan Aktif"
    }


# =========================
# PREDIKSI 1 SISWA
# =========================
@app.post("/prediksi")
def prediksi(data_input: JurusanInput):

    # =========================
    # INPUT MODEL
    # =========================
    X = np.array([[
        data_input.kompetensi,
        data_input.nilai_akademik
    ]])

    # =========================
    # SCALING
    # =========================
    X_scaled = scaler.transform(X)

    # =========================
    # PREDICT PROBA
    # =========================
    probabilities = model.predict_proba(X_scaled)[0]

    classes = model.classes_

    # =========================
    # PERSENTASE JURUSAN 1
    # =========================
    persen_j1 = 0

    if data_input.jurusan_1 in classes:

        idx1 = list(classes).index(data_input.jurusan_1)

        persen_j1 = float(probabilities[idx1] * 100)

    # =========================
    # PERSENTASE JURUSAN 2
    # =========================
    persen_j2 = 0

    if data_input.jurusan_2 in classes:

        idx2 = list(classes).index(data_input.jurusan_2)

        persen_j2 = float(probabilities[idx2] * 100)

    # =========================
    # HASIL PREDIKSI
    # =========================
    if persen_j1 >= persen_j2:

        prediksi_jurusan = data_input.jurusan_1

    else:

        prediksi_jurusan = data_input.jurusan_2

    # =========================
    # RETURN JSON
    # =========================
    return {

        "nama_siswa": data_input.nama_siswa,

        "kompetensi": data_input.kompetensi,

        "nilai_akademik": data_input.nilai_akademik,

        "jurusan_1": data_input.jurusan_1,

        "persentase_jurusan_1": round(persen_j1, 2),

        "jurusan_2": data_input.jurusan_2,

        "persentase_jurusan_2": round(persen_j2, 2),

        "prediksi_jurusan": prediksi_jurusan

    }


# =========================
# PREDIKSI SEMUA DATASET
# =========================
@app.get("/prediksi-semua")
def prediksi_semua():

    hasil = []

    for index, row in data.iterrows():

        # input model
        X = np.array([[
            row['kompetensi'],
            row['nilai_akademik']
        ]])

        # scaling
        X_scaled = scaler.transform(X)

        # predict proba
        probabilities = model.predict_proba(X_scaled)[0]

        classes = model.classes_

        jurusan1 = row['jurusan_1']

        jurusan2 = row['jurusan_2']

        # persen jurusan 1
        persen_j1 = 0

        if jurusan1 in classes:

            idx1 = list(classes).index(jurusan1)

            persen_j1 = float(probabilities[idx1] * 100)

        # persen jurusan 2
        persen_j2 = 0

        if jurusan2 in classes:

            idx2 = list(classes).index(jurusan2)

            persen_j2 = float(probabilities[idx2] * 100)

        # prediksi akhir
        if persen_j1 >= persen_j2:

            prediksi = jurusan1

        else:

            prediksi = jurusan2

        hasil.append({

            "nama_siswa": row['nama_siswa'],

            "kompetensi": row['kompetensi'],

            "nilai_akademik": row['nilai_akademik'],

            "jurusan_1": jurusan1,

            "persentase_jurusan_1": round(persen_j1, 2),

            "jurusan_2": jurusan2,

            "persentase_jurusan_2": round(persen_j2, 2),

            "prediksi_jurusan": prediksi

        })

    return {
        "hasil": hasil
    }