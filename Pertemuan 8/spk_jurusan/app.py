from flask import Flask, request
import joblib
import numpy as np
import pandas as pd

app = Flask(__name__)

# Load model & scaler
model = joblib.load("model_jurusan.pkl")
scaler = joblib.load("scaler_jurusan.pkl")

# Load dataset
data = pd.read_csv("../ml_api/Dataset_Jurusan.csv")

# =========================
# TEMPLATE UI (BIAR RAPI)
# =========================
def template(title, content):
    return f"""
    <html>
    <head>
        <title>{title}</title>
        <style>
            body {{
                font-family: Arial;
                margin: 0;
                background: #f4f6f9;
            }}
            .navbar {{
                background: #007bff;
                padding: 15px;
                color: white;
                text-align: center;
                font-size: 20px;
            }}
            .menu {{
                display: flex;
                justify-content: center;
                gap: 20px;
                margin: 20px;
            }}
            .menu a {{
                text-decoration: none;
                padding: 10px 15px;
                background: white;
                border-radius: 5px;
                color: #007bff;
                font-weight: bold;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            }}
            .container {{
                width: 90%;
                margin: auto;
            }}
            .card {{
                background: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                margin-bottom: 20px;
            }}
            table {{
                border-collapse: collapse;
                width: 100%;
            }}
            th, td {{
                border: 1px solid #ddd;
                padding: 8px;
                text-align: center;
            }}
            th {{
                background: #007bff;
                color: white;
            }}
            tr:nth-child(even) {{
                background: #f2f2f2;
            }}
            input {{
                padding: 10px;
                width: 100%;
                margin: 10px 0;
            }}
            button {{
                padding: 10px;
                background: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
                width: 100%;
                font-size: 16px;
            }}
            .result {{
                font-size: 20px;
                text-align: center;
                margin-top: 20px;
                font-weight: bold;
            }}
        </style>
    </head>

    <body>

        <div class="navbar">
            SPK Penentuan Jurusan (Machine Learning)
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
        <p>Aplikasi ini digunakan untuk menentukan rekomendasi jurusan berdasarkan nilai akademik dan minat menggunakan metode Random Forest.</p>
        <ul>
            <li><b>Dataset</b> → melihat data</li>
            <li><b>Informasi Model</b> → melihat hasil training</li>
            <li><b>Prediksi</b> → mencoba prediksi</li>
        </ul>
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
        <p>Total Data: {len(data)}</p>
        {tabel}
    </div>
    """
    return template("Dataset", content)


# =========================
# MODEL INFO
# =========================
@app.route('/model')
def model_info():
    importances = model.feature_importances_

    content = f"""
    <div class="card">
        <h2>Informasi Model</h2>
        <p><b>Feature Importance:</b></p>
        <ul>
            <li>Nilai Akademik: {importances[0]:.3f}</li>
            <li>Minat: {importances[1]:.3f}</li>
        </ul>
        <p>Semakin tinggi nilai, semakin berpengaruh terhadap keputusan model.</p>
    </div>
    """
    return template("Model", content)


# =========================
# PREDIKSI FORM
# =========================
@app.route('/prediksi')
def prediksi():
    content = """
    <div class="card">
        <h2>Prediksi Jurusan</h2>
        <form method="post" action="/hasil">
            <input type="number" name="nilai" placeholder="Nilai Akademik" required>
            <input type="number" name="minat" placeholder="Minat" required>
            <button type="submit">Prediksi</button>
        </form>
    </div>
    """
    return template("Prediksi", content)


# =========================
# HASIL
# =========================
@app.route('/hasil', methods=['POST'])
def hasil():
    nilai = float(request.form['nilai'])
    minat = float(request.form['minat'])

    data_input = np.array([[nilai, minat]])
    data_scaled = scaler.transform(data_input)

    # prediksi kelas
    pred = model.predict(data_scaled)[0]

    # ambil probabilitas
    prob = model.predict_proba(data_scaled)[0]

    hasil_text = "Direkomendasikan" if pred == 1 else "Tidak Direkomendasikan"

    content = f"""
    <div class="card">
        <h2>Hasil Prediksi</h2>

        <div class="result">{hasil_text}</div>

        <h3>Probabilitas Model:</h3>
        <p>Tidak Direkomendasikan: <b>{prob[0]*100:.1f}%</b></p>
        <p>Direkomendasikan: <b>{prob[1]*100:.1f}%</b></p>

        <p style="font-size:12px; color:gray;">
        *Probabilitas menunjukkan tingkat keyakinan model terhadap hasil prediksi.
        </p>
    </div>
    """

    return template("Hasil", content)


# =========================
# RUN SERVER (IP ACCESS)
# =========================
if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)
