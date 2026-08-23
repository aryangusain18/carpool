# Report — DA5401 Assignment 2

## Problem 1: Predicting Maintenance Job Cost

**Cross-validation (training data only, 5 folds):** Mean Absolute Error (MAE),the average dollar amount by which predictions miss the actual cost, came out to **$646.34** on average across the 5 folds, with a standard deviation of **$37.53**. That's a fairly tight spread, suggesting the model performs consistently regardless of which slice of the training data it sees.

**Performance on the held-out test set** (data the model never touched during training or tuning):

- MAE: **$663.07** — on average, the model's cost estimate is off by about $663.
- RMSE: **$866.71** — a bit higher than MAE, which tells us a handful of jobs have noticeably larger errors than the "typical" job.
- MAPE: **0.0959**, i.e. roughly a 9.6% error relative to the actual job cost.
- R²: **0.8359** — the model explains about 84% of the variation in job cost across jobs.

**Which single metric best fits this use case?** I'd pick **MAE** as the primary business metric. These predictions exist to help with budgeting, so the most useful number is one expressed directly in the currency being budgeted, and MAE gives exactly that: "expect to be off by about $663 per job, on average." Because it doesn't square the errors the way RMSE does, MAE also isn't thrown off by a few unusually expensive jobs, it reflects *typical* performance rather than being dragged around by outliers, which matters more for planning across a whole portfolio of jobs than for any single worst case. MAPE is a useful sanity check when comparing across job sizes, but a percentage isn't something you can directly put into a budget line, and R² is more of a "how good is the model overall" statistic than something a planner can act on.

## Problem 2: Predicting Critical Machine Failure Within 30 Days

Because failing to catch a machine that's actually about to break down is costly, the business set a hard requirement: the chosen decision threshold must catch **at least 85% of real failures** (recall ≥ 0.85) on the validation data, and among thresholds that clear that bar, we pick whichever gives the best precision (fewest false alarms).

**Threshold selection (using the validation set only):**
- Selected threshold: **0.1115**
- Precision at this threshold: **0.3267**
- Recall at this threshold: **0.8684**

**Final evaluation on the untouched test set,** after refitting the model on training + validation data and applying that fixed threshold:

- TN (correctly predicted no failure): **191**
- FP (predicted failure, but machine was fine): **72**
- FN (predicted no failure, but machine actually failed): **8**
- TP (correctly predicted failure): **29**
- Accuracy: **0.7333**
- Precision: **0.2871**
- Recall: **0.7838**
- Specificity: **0.7262**
- F1 score: **0.4203**

**Did this generalise well?** Reasonably, but not perfectly. Test recall (0.78) came in below both the validation recall (0.87) and the 0.85 target. That's not a sign of a broken model, though with only around 37 machines that actually failed in each of the validation and test sets, recall estimates near a decision boundary are naturally a bit noisy; missing just one or two more failures than expected is enough to produce a gap this size. Precision, meanwhile, held up fairly close to its validation value (0.287 vs 0.327), suggesting the model's underlying behaviour is stable and the recall dip is mostly a small-sample effect rather than a fundamental mismatch between the validation and test data. If this were going into production, a small safety margin picking a threshold that clears, say, 0.90 recall on validation would make the 0.85 guarantee hold up more reliably on new data.
