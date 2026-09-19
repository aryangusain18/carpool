# Problem 1 — XGBoost Regression

**Split seed:** 2

**Training and validation RMSE for every supplied number of estimators**
(`max_depth=3`, `learning_rate=0.1`)

| n_estimators | Train RMSE | Validation RMSE |
|---:|---:|---:|
| 1   | 75.7790 | 78.1399 |
| 10  | 51.8733 | 55.7710 |
| 25  | 37.2551 | 43.6579 |
| 50  | 27.8817 | 35.6849 |
| 100 | 22.5167 | 31.3319 |
| 200 | 19.9015 | 30.3118 |

**Selected number of estimators:** 200 (lowest validation RMSE = 30.3118)

**Validation RMSE — full sampling vs. subsampling** (at n_estimators = 200)

| Configuration | subsample | colsample_bytree | Validation RMSE |
|---|---:|---:|---:|
| Full sampling | 1.0 | 1.0 | 30.3118 |
| Subsampled    | 0.8 | 0.8 | 30.1762 |

**Selected sampling configuration:** Subsampled (subsample=0.8, colsample_bytree=0.8)

**Final test metrics** (refit on combined train+validation, evaluated once on test)

| MAE | RMSE | R² |
|---:|---:|---:|
| 21.8532 | 28.3057 | 0.8653 |

**Top five features by weight, gain, and cover**

| Rank | Weight | Gain | Cover |
|---:|---|---|---|
| 1 | production_rate_tph (220) | production_rate_tph (179253.22) | shift_index (1434.79) |
| 2 | ambient_temp_c (179) | feed_moisture_pct (50557.36) | production_rate_tph (1012.10) |
| 3 | feed_moisture_pct (166) | ambient_temp_c (44958.94) | downtime_hours (965.35) |
| 4 | vibration_mm_s (160) | equipment_age_years (21868.21) | feed_moisture_pct (930.61) |
| 5 | equipment_age_years (159) | vibration_mm_s (21585.48) | noise_sensor_1 (900.26) |

**Observations on the three feature-importance rankings**

Weight and gain agree almost exactly at the top: `production_rate_tph` ranks first under both, and the same five features fill both top-5 lists, only reordered. Cover tells a different story , `shift_index`, ranked last (11th) by weight and 6th by gain, ranks 1st by cover, because its few splits each partition a very large share of the training rows. `noise_sensor_1`, essentially uncorrelated with the target, ranks 5th by cover while ranking 10th (weight) and last (gain), showing cover reflects how much data passes through a feature's splits rather than how useful those splits are.

---

# Problem 2 — CatBoost Classification

**Split seed:** 2

**Cardinalities of the categorical predictors**

| Column | Unique categories |
|---|---:|
| city | 40 |
| branch | 150 |
| sales_agent | 250 |
| occupation | 10 |
| customer_segment | 4 |
| channel | 4 |
| product_family | 5 |
| region | 5 |

**Validation ROC-AUC and F1 for every supplied CatBoost configuration** (`depth=6`)

| Config | Iterations | Learning Rate | Validation ROC-AUC | Validation F1 |
|---|---:|---:|---:|---:|
| A | 50  | 0.20 | 0.6199 | 0.0672 |
| B | 150 | 0.08 | 0.6184 | 0.0179 |
| C | 400 | 0.03 | 0.6074 | 0.0174 |

**Selected configuration:** A (iterations=50, learning_rate=0.20, depth=6) — highest validation ROC-AUC

**Final test evaluation** (refit on combined train+validation, evaluated once on test)

Confusion matrix:

| | Predicted 0 | Predicted 1 |
|---|---:|---:|
| **Actual 0** | TN = 337 | FP = 3 |
| **Actual 1** | FN = 108 | TP = 2 |

| Accuracy | Precision | Recall | F1 | ROC-AUC |
|---:|---:|---:|---:|---:|
| 0.7533 | 0.4000 | 0.0182 | 0.0348 | 0.6446 |

**Observations based on the computed ordered encodings and categorical cardinalities**

Naive target encoding is leaky by construction.Every row of a category receives that category's own overall response rate (computed using the row's own label) giving a relatively tight per-column spread (std 0.016–0.119 across the eight columns); ordered encoding is consistently more spread out (std 0.038–0.163) because each row only sees the category's history up to that point rather than the full-sample average. Cardinality controls how often that history is empty: `sales_agent` (250 categories) and `branch` (150 categories) have 8.33% and 5.00% of rows as a category's first occurrence encoded using only the prior (0.5) versus 0.13%–0.17% for the four lowest-cardinality columns (`customer_segment`, `channel`, `product_family`, `region`, each with 4–5 categories). This is precisely why the two high-cardinality columns are also where naive target encoding leaks the most, since with few observations per category a category's own mean collapses toward individual rows' own labels which is why CatBoost is trained on the raw categorical columns via `cat_features` rather than on either encoding.

**Top five features by mean absolute SHAP value**

| Rank | Feature | Mean \|SHAP\| |
|---:|---|---:|
| 1 | customer_segment | 0.2551 |
| 2 | channel | 0.1748 |
| 3 | product_family | 0.1630 |
| 4 | city | 0.1219 |
| 5 | monthly_spend | 0.0805 |

**Five largest absolute feature contributions for the selected test observation**
(test-set row 0, `customer_id` = CUST-02690)

| Rank | Feature | SHAP value |
|---:|---|---:|
| 1 | customer_segment | -0.2220 |
| 2 | channel | -0.1637 |
| 3 | city | +0.1584 |
| 4 | age | +0.1569 |
| 5 | monthly_spend | -0.1364 |
