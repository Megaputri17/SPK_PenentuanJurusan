import pandas as pd
from sklearn.ensemble import RandomForestRegressor
import joblib

# DATA TRAINING
data = {
    'kepadatan': [0.000448, 0.000251, 0.000259, 0.000715, 0.000543],
    'jarak_jalan': [0.004634, 0.005307, 0.004634, 0.005770, 0.002756],
    'sekolah_eksisting': [1, 3, 1, 4, 2],
    'skor': [0.90, 0.50, 0.88, 0.40, 0.80]
}

# DATAFRAME
df = pd.DataFrame(data)

# FEATURE
X = df[['kepadatan', 'jarak_jalan', 'sekolah_eksisting']]

# TARGET
y = df['skor']

# MODEL
model = RandomForestRegressor()

# TRAINING
model.fit(X, y)

# SIMPAN MODEL
joblib.dump(model, 'model_zonasi.pkl')

print('Model berhasil dibuat!')