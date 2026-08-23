# Report — DA5401 Assignment 2

## Problem 1 — Regression (`job_cost`)

- 5-fold CV MAE: mean = 646.34, std = 37.53
- Test MAE: 663.07
- Test RMSE: 866.71
- Test MAPE: 0.0959 (≈9.59%)
- Test R²: 0.8359
- Primary business metric: **MAE**

**Justification:** `job_cost` predictions are used for budgeting, so the most
useful error measure is one expressed directly in the currency units that get
budgeted. MAE (~$663) gives the typical absolute dollar deviation per job and,
unlike RMSE (~$867), is not dominated by a small number of unusually expensive
jobs, making it the more stable, directly actionable figure for setting
per-job budget buffers. MAPE is a useful scale-free cross-check but is less
directly usable when allocating an actual currency amount, and R² describes
overall fit rather than a usable error magnitude.

## Problem 2 — Classification (`critical_failure_30d`)

- Selected validation threshold: 0.1115
- Validation precision at threshold: 0.3267
- Validation recall at threshold: 0.8684
- Test confusion matrix: TN = 191, FP = 72, FN = 8, TP = 29
- Test accuracy: 0.7333
- Test precision: 0.2871
- Test recall: 0.7838
- Test specificity: 0.7262
- Test F1: 0.4203

**Justification:** Among validation thresholds achieving recall ≥ 0.85, 0.1115
gave the highest precision (0.3267 at recall 0.8684). On the untouched test
set, recall fell to 0.7838:below the 0.85 requirement while precision
stayed close to its validation value (0.2871 vs 0.3267). With only ~37
positive cases in each split, the recall estimate near the decision boundary
is noisy, so this shortfall is a plausible sampling effect rather than
evidence of a fundamentally different test distribution. The operating point
generalises reasonably but not perfectly ,a small safety margin (a slightly
lower threshold) would make the recall requirement more robust on new data.
