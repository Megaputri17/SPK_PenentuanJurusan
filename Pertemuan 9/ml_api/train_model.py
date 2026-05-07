import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score
from sklearn.preprocessing import StandardScaler
import joblib

# ======================
# LOAD DATASET
# ======================
data = pd.read_csv("Dataset_Jurusan.csv")

# ======================
# FITUR
# ======================
X = data[['kompetensi', 'nilai_akademik']]

# ======================
# TARGET
# ======================
y = data['jurusan_1']

# ======================
# SCALING
# ======================
scaler = StandardScaler()
X_scaled = scaler.fit_transform(X)

# ======================
# SPLIT DATA
# ======================
X_train, X_test, y_train, y_test = train_test_split(
    X_scaled,
    y,
    test_size=0.2,
    random_state=42
)

# ======================
# MODEL RANDOM FOREST
# ======================
model = RandomForestClassifier(
    n_estimators=100,
    random_state=42
)

# ======================
# TRAINING
# ======================
model.fit(X_train, y_train)

# ======================
# EVALUASI
# ======================
y_pred = model.predict(X_test)

akurasi = accuracy_score(y_test, y_pred)

print(f"Akurasi Model: {akurasi*100:.1f}%")

# ======================
# SIMPAN MODEL
# ======================
joblib.dump(model, 'model_jurusan.pkl')
joblib.dump(scaler, 'scaler_jurusan.pkl')

print("Model berhasil disimpan!")