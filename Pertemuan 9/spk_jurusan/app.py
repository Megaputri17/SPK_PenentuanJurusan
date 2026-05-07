from flask import Flask, request
import joblib
import numpy as np
import pandas as pd
import requests

app = Flask(__name__)

# =========================
# LOAD MODEL & DATASET
# =========================
rf_model = joblib.load("../ml_api/model_jurusan.pkl")
scaler = joblib.load("../ml_api/scaler_jurusan.pkl")

data = pd.read_csv("../ml_api/Dataset_Jurusan.csv")

# =========================
# TEMPLATE UI
# =========================
def template(title, content):

    return f"""
    <html>

    <head>

        <title>{title}</title>

        <style>

            body {{
                margin: 0;
                font-family: Arial;
                background: #f4f6f9;
            }}

            .navbar {{
                background: #007bff;
                color: white;
                padding: 18px;
                text-align: center;
                font-size: 24px;
                font-weight: bold;
            }}

            .menu {{
                display: flex;
                justify-content: center;
                gap: 20px;
                padding: 20px;
            }}

            .menu a {{
                text-decoration: none;
                background: white;
                padding: 12px 20px;
                border-radius: 10px;
                color: #007bff;
                font-weight: bold;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }}

            .container {{
                width: 95%;
                margin: auto;
            }}

            .card {{
                background: white;
                padding: 25px;
                border-radius: 12px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                margin-bottom: 25px;
            }}

            h2 {{
                margin-top: 0;
                color: #333;
            }}

            table {{
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }}

            th {{
                background: #007bff;
                color: white;
                padding: 12px;
            }}

            td {{
                padding: 10px;
                border: 1px solid #ddd;
                text-align: center;
            }}

            tr:nth-child(even) {{
                background: #f2f2f2;
            }}

            .success {{
                color: green;
                font-weight: bold;
            }}

            .top {{
                background: #d4edda !important;
            }}

        </style>

    </head>

    <body>

        <div class="navbar">
            SPK Penentuan Jurusan Menggunakan Random Forest
        </div>

        <div class="menu">
            <a href="/">Home</a>
            <a href="/dataset">Dataset</a>
            <a href="/model">Informasi Model</a>
            <a href="/prediksi">Prediksi</a>
        </div>

        <div class="container">
            {content}
        </div>

    </body>

    </html>
    """


# =========================
# HOME
# =========================
@app.route('/')
def home():

    content = """
    <div class="card">

        <h2>Selamat Datang</h2>

        <p>
        Sistem Pendukung Keputusan Penentuan Jurusan
        menggunakan algoritma Random Forest.
        </p>

        <p>
        Sistem ini digunakan untuk memberikan rekomendasi
        jurusan berdasarkan nilai kompetensi dan nilai akademik siswa.
        </p>

    </div>
    """

    return template("Home", content)


# =========================
# DATASET
# =========================
@app.route('/dataset')
def dataset():

    tabel = data.to_html(index=False)

    content = f"""
    <div class="card">

        <h2>Dataset Jurusan</h2>

        <p>Total Dataset : <b>{len(data)}</b></p>

        {tabel}

    </div>
    """

    return template("Dataset", content)


# =========================
# INFORMASI MODEL
# =========================
@app.route('/model')
def info_model():

    importances = rf_model.feature_importances_

    content = f"""
    <div class="card">

        <h2>Informasi Model Random Forest</h2>

        <table>

            <tr>
                <th>Fitur</th>
                <th>Importance</th>
            </tr>

            <tr>
                <td>Kompetensi</td>
                <td>{importances[0]:.3f}</td>
            </tr>

            <tr>
                <td>Nilai Akademik</td>
                <td>{importances[1]:.3f}</td>
            </tr>

        </table>

        <br>

        <p>
        Feature importance menunjukkan tingkat pengaruh
        fitur terhadap hasil rekomendasi jurusan.
        </p>

    </div>
    """

    return template("Informasi Model", content)

# =========================
# PREDIKSI
# =========================
@app.route('/prediksi')
def prediksi():

    response = requests.get(
        "http://127.0.0.1:8000/prediksi-semua"
    )

    hasil = response.json()['hasil']

    rows = ""

    for h in hasil:

        rows += f"""
        <tr>
            <td>{h['nama_siswa']}</td>
            <td>{h['jurusan_1']}</td>
            <td>{h['persentase_jurusan_1']}%</td>
            <td>{h['jurusan_2']}</td>
            <td>{h['persentase_jurusan_2']}%</td>
            <td>{h['prediksi_jurusan']}</td>
        </tr>
        """

    content = f"""

    <div class="card">

        <h2>Hasil Prediksi</h2>

        <table>

            <tr>
                <th>Nama</th>
                <th>Jurusan 1</th>
                <th>% J1</th>
                <th>Jurusan 2</th>
                <th>% J2</th>
                <th>Prediksi</th>
            </tr>

            {rows}

        </table>

    </div>
    """

    return template("Prediksi", content)

# ========================= 
# RUN SERVER 
#  ========================= 
if __name__ == "__main__": 
    app.run(host="0.0.0.0", port=5000, debug=True)
