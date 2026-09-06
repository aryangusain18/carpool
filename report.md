# DA5401 — Assignment 3 — Report

**Roll number:** DA26M002

## Problem 1 — Decision Tree Classifier from Scratch

**split_seed:** 2 *(last two digits of roll number DA26M002)*

| max_depth | train_accuracy | validation_accuracy |
|:---------:|:---------------:|:--------------------:|
| 1 | 0.6490 | 0.5333 |
| 2 | 0.6592 | 0.5238 |
| 3 | 0.6939 | 0.5905 |
| 4 | 0.7429 | 0.6571 |
| 5 | 0.7837 | 0.6571 |
| 6 | 0.8347 | 0.6381 |

- **underfit_depth:** 1
- **overfit_depth:** 6
- **best_depth:** 4
- **Final test accuracy (depth = 4, trained on combined train+validation data):** 0.6381

**Interpretation:** At depth 1 the tree is too simple to capture the structure in the data, so both training and validation accuracy are low and close together — the classic signature of underfitting. As depth increases, training accuracy climbs steadily (up to 0.835 at depth 6), but validation accuracy peaks around depth 4–5 and then falls at depth 6, so the train–validation gap widens to its largest value (0.197) at depth 6 — the tree is starting to fit noise specific to the training set rather than the underlying pattern. Depth 4 is selected as the best depth because it matches the peak validation accuracy of depth 5 with a shallower, less complex tree.

## Problem 2 — Random Forest Regression

**split_seed:** 2 *(same derivation — last two digits of roll number DA26M002)*

**5-fold cross-validation MAE (training set only):**

| Model | mean CV MAE | std CV MAE |
|:---|:---:|:---:|
| Single tree (baseline) | 11.2171 | 0.6284 |
| Random Forest, n_estimators=10 | 8.1338 | 0.6063 |
| Random Forest, n_estimators=50 | 7.6691 | 0.5279 |
| Random Forest, n_estimators=100 | 7.5332 | 0.5710 |
| Random Forest, n_estimators=200 | 7.5568 | 0.5883 |

- **Selected n_estimators:** 100 *(lowest mean CV MAE)*

**Test-set performance (held-out 20%, evaluated once):**

| Model | MAE | RMSE | R² |
|:---|:---:|:---:|:---:|
| Single tree (baseline) | 11.5883 | 14.6317 | 0.1059 |
| Random Forest (n_estimators=100) | 7.4563 | 9.3880 | 0.6319 |

**Interpretation:** A single, unpruned decision tree fits perfectly to whatever training fold it sees and overfits the noise in that fold, which is why its cross-validation MAE (11.22 hours) is far higher than every Random Forest setting and its test R² (0.106) explains only a small fraction of the variance in maintenance duration. Averaging over 100 randomized, bootstrap-sampled trees cancels out much of that overfitting: test MAE falls from 11.59 to 7.46 hours and R² rises to 0.632. The fold-to-fold standard deviation of CV MAE is somewhat lower for the forest (0.57) than the tree (0.63), but the larger effect by far is the drop in average error rather than in fold-to-fold variability.
