import pandas as pd
import xgboost as xgb
import numpy as np
import joblib
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import LabelEncoder
from sklearn.metrics import mean_squared_error, mean_absolute_error, r2_score

# Load Excel Data
df = pd.read_excel("COD_testrun2.xlsx")

# **Step 1: Define All Possible Sectors (Including "nan")**
sector_list = [
    "nan", "Biofuels", "Chemical logistics", "Chemical production", "Dairy", "Dairy food/wastewater",
    "Farming", "Fish (Shrimps processing)", "Fish processing", "Food", "Food industry", "Food/ wastewater",
    "Laundry", "PFAS", "PFAS Removal", "Paper", "Paper recycling", "Plastic", "RWZI", "Steel", "Wastewater",
    "Wastewater treatment", "Water treatment Algae", "coatings", "waste management", "Beverages/Waste water"
]

# **Step 2: Strip Extra Spaces and Replace Missing Values with "nan"**
df['Sector'] = df['Sector'].astype(str).str.strip().replace("", "nan")

# **Step 3: Train LabelEncoder for "Sector"**
sector_le = LabelEncoder()
sector_le.fit(sector_list)  # Ensure all values are included
df['Sector'] = df['Sector'].apply(lambda x: x if x in sector_list else "nan")  # Handle unseen labels
df['Sector'] = sector_le.transform(df['Sector'])  # Encode values

# **Step 4: Store the LabelEncoder for Later Use**
label_encoders = {"Sector": sector_le}

# Select features & target
X = df.drop(columns=['cod(after)'])  # Features
y = df['cod(after)']  # Target

# Split data
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Train XGBoost model
model = xgb.XGBRegressor(n_estimators=100, learning_rate=0.1, max_depth=5, random_state=42)
model.fit(X_train, y_train)

# Save model & label encoders
joblib.dump(model, 'xgboost_cod_model.pkl')
joblib.dump(label_encoders, 'label_encoders.pkl')

# Model evaluation
y_pred = model.predict(X_test)
print(f"R² Score: {r2_score(y_test, y_pred)}")
print(f"RMSE: {np.sqrt(mean_squared_error(y_test, y_pred))}")
print(f"MAE: {mean_absolute_error(y_test, y_pred)}")
