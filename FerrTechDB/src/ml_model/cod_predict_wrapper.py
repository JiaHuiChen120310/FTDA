# cod_predict_wrapper.py
import sys
import json
import joblib
import numpy as np

# Load model
with open('../ml_model/xgboost_cod_model.pkl', 'rb') as f:
    model = joblib.load(f)

# Load encoders
with open('../ml_model/sector_encoder.pkl', 'rb') as f:
    sector_encoder = joblib.load(f)

with open('../ml_model/shared_encoder.pkl', 'rb') as f:
    shared_encoder = joblib.load(f)

# Read input JSON from PHP
input_json = sys.stdin.read()
input_data = json.loads(input_json)

# Log the raw input JSON to check all keys
with open("input_log_raw.json", "a") as f:
    f.write(f"Raw input JSON: {input_data}\n")

# Handle missing values
def safe_get(key, default=""):
    return str(input_data.get(key, default))

# Encode sector
sector = safe_get('Sector')
sector = str(sector)
with open("input_log_sector.txt", "a") as f:
        f.write(f" : {sector}")
sector_encoded = sector_encoder.transform([sector])[0] if sector else 15
with open("input_log_sector_encoder.txt", "a") as f:
        f.write(f" : {sector_encoded}")
        
with open("input_log_sector_classes.txt", "a") as f:
    f.write(f"\nComparing: {repr(sector)} to {list(sector_encoder.classes_)}\n")

# Encode chemical names (chem1 to chem10)
chem_features = []
for i in range(1, 11):
    chem_key = f'chem{i}'
    chem_name = safe_get(chem_key)
    if chem_name:
        encoded_chem = shared_encoder.transform([chem_name])[0]
    else:
        encoded_chem = 0
    chem_features.append(encoded_chem)

# Get chemical dosages (chem1 dose to chem10 dose)
dose_features = []
for i in range(1, 11):
    dose_key = f'chem{i}_dose'
    dose_val = input_data.get(dose_key, 0)
    try:
        dose_features.append(float(dose_val))
    except:
        dose_features.append(0.0)

# Get COD before value
raw_cod_before = input_data.get('cod_before', 0.0)
try:
    cod_before = float(raw_cod_before)
except (ValueError, TypeError):
    cod_before = 0.0

# Construct feature vector (match training order)
feature_vector = [sector_encoded, cod_before]  # Start with 'Sector' and 'cod(before)'

# Interleave chem_features and dose_features
for i in range(len(chem_features)):
    feature_vector.extend([chem_features[i], dose_features[i]])  

X = np.array([feature_vector])
with open("input_log.txt", "a") as f:
    f.write(f"Input data: {X.tolist()}\n")

# Predict
prediction = model.predict(X)[0]

# Output prediction
print(json.dumps({"prediction": float(prediction)}))
