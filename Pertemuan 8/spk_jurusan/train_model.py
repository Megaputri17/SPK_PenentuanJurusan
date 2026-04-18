import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, classification_report
from sklearn.preprocessing import StandardScaler
import joblib

# 1. Load dataset
data = pd.read_csv("../ml_api/Dataset_Jurusan.csv")

# 2. Pisahkan fitur (X) dan label (y)
# X = nilai siswa
# y = rekomendasi (0/1)
X = data[['nilai_akademik', 'minat']]
y = data['label']

# 3. Scaling fitur
scaler = StandardScaler()
X_scaled = scaler.fit_transform(X)

# 4. Split data
X_train, X_test, y_train, y_test = train_test_split(
    X_scaled, y, test_size=0.2, random_state=42
)

# 5. Training model Random Forest
model = RandomForestClassifier(n_estimators=100, random_state=42)
model.fit(X_train, y_train)

# 6. Evaluasi
y_pred = model.predict(X_test)
akurasi = accuracy_score(y_test, y_pred)

print(f"Akurasi Model: {akurasi * 100:.1f}%")
print(classification_report(y_test, y_pred))

# 7. Feature importance
importances = model.feature_importances_
print(f"Nilai Akademik importance: {importances[0]:.3f}")
print(f"Minat importance:          {importances[1]:.3f}")

# 8. Simpan model
joblib.dump(model,  'model_jurusan.pkl')
joblib.dump(scaler, 'scaler_jurusan.pkl')

print("Model dan scaler berhasil disimpan.")