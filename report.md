# DA5401 — Assignment 6 Report

**Name:** Aryan Gusain  **Roll No.:** DA26M002  **student_seed:** 2 (last two digits of roll number)

---

## Problem 1 — Density-Based Clustering (DBSCAN and HDBSCAN)

Features were standardized with `StandardScaler`. The dataset has 2450 points. The silhouette score is computed on non-noise points only. Noise fraction is noise points divided by 2450.

### DBSCAN (Euclidean distance)

| eps | min_samples | Clusters | Noise fraction | Cluster sizes | Silhouette |
|---|---|---|---|---|---|
| 0.12 | 5 | 4 | 0.0792 | [340, 472, 491, 953] | 0.5169 |
| 0.18 | 5 | 5 | 0.0641 | [5, 7, 478, 492, 1311] | 0.2680 |
| 0.24 | 8 | 3 | 0.0559 | [490, 495, 1328] | 0.4918 |
| 0.30 | 10 | 4 | 0.0445 | [10, 493, 500, 1338] | 0.4010 |

**Selected DBSCAN configuration:** `eps = 0.12`, `min_samples = 5` (highest silhouette, 0.5169).

### HDBSCAN (`min_samples=None`, `metric="euclidean"`)

| min_cluster_size | Clusters | Noise fraction | Cluster sizes | Silhouette |
|---|---|---|---|---|
| 20 | 4 | 0.0763 | [337, 481, 495, 950] | 0.5159 |
| 40 | 3 | 0.0669 | [475, 495, 1316] | 0.4969 |
| 70 | 3 | 0.0718 | [474, 495, 1305] | 0.5001 |
| 100 | 3 | 0.0804 | [473, 494, 1286] | 0.5062 |

**Selected HDBSCAN configuration:** `min_cluster_size = 20` (highest silhouette, 0.5159).

### Selected solutions

| Method | Configuration | Clusters | Cluster sizes | Noise fraction | Silhouette |
|---|---|---|---|---|---|
| DBSCAN | eps = 0.12, min_samples = 5 | 4 | [340, 472, 491, 953] | 0.0792 | 0.5169 |
| HDBSCAN | min_cluster_size = 20 | 4 | [337, 481, 495, 950] | 0.0763 | 0.5159 |

---

## Problem 2 — Random Forest Hyperparameter Tuning

Stratified 80/20 train/test split with `student_seed = 2`. Tuning used 4-fold stratified CV on the training set with ROC-AUC as the objective. The test set was used only once, for the final evaluation.

### Tuning results

| Method | Best CV ROC-AUC | Configurations / trials evaluated |
|---|---|---|
| Grid Search | 0.9504 | 8 |
| Random Search | 0.9505 | 8 |
| Bayesian Optimization (Optuna) | 0.9496 | 8 |

### Best hyperparameters

| Method | n_estimators | max_depth | min_samples_split | max_features |
|---|---|---|---|---|
| Grid Search | 150 | None | 2 | sqrt |
| Random Search | 200 | None | 2 | log2 |
| Bayesian Optimization | 213 | 10 | 2 | log2 |

### Final test-set performance

| Method | Test ROC-AUC | Test F1 |
|---|---|---|
| Grid Search | 0.9630 | 0.8598 |
| Random Search | 0.9651 | 0.8562 |
| Bayesian Optimization | 0.9601 | 0.8474 |

---

## Problem 3 — Unsupervised Anomaly Detection (PyOD)

Sensor features were standardized (`record_id` excluded). Settings: `contamination = 0.10`, `n_neighbors = 20`, `flag_fraction = 0.10`. Isolation Forest used `n_estimators = 200`, `random_state = 42`.

### Flag counts

| Model | Observations flagged |
|---|---|
| KNN | 300 |
| LOF | 300 |
| Isolation Forest | 300 |

### Top 10 `record_id` values by anomaly score (most anomalous first)

| Rank | KNN | LOF | Isolation Forest |
|---|---|---|---|
| 1 | REC-00035 | REC-00672 | REC-00129 |
| 2 | REC-00259 | REC-00325 | REC-01247 |
| 3 | REC-02873 | REC-02855 | REC-00863 |
| 4 | REC-01662 | REC-00275 | REC-02414 |
| 5 | REC-00950 | REC-01666 | REC-00049 |
| 6 | REC-00036 | REC-01794 | REC-01590 |
| 7 | REC-01369 | REC-02524 | REC-01634 |
| 8 | REC-01112 | REC-01175 | REC-02386 |
| 9 | REC-01941 | REC-01229 | REC-02408 |
| 10 | REC-01065 | REC-01537 | REC-02925 |

### Pairwise overlap of flagged observations

| Pair | Flagged by both |
|---|---|
| KNN and LOF | 104 |
| KNN and Isolation Forest | 189 |
| LOF and Isolation Forest | 68 |

---

## Problem 4 — Semi-Supervised Anomaly Detection (Pseudo-Labeling)

Subset sizes: 235 labeled, 2140 unlabeled, 625 evaluation rows. Both Random Forests used `n_estimators = 200`, `class_weight = "balanced"`, `random_state = 42`. Pseudo-label thresholds: `low_threshold = 0.10`, `high_threshold = 0.90`. Evaluation labels were not used for training or pseudo-labeling.

### Pseudo-labels added

| Pseudo-normal (label 0) | Pseudo-anomaly (label 1) | Total added |
|---|---|---|
| 1390 | 112 | 1502 |

### Evaluation-set results (F1 at probability threshold 0.5)

| Model | ROC-AUC | F1 |
|---|---|---|
| Initial (labeled rows only) | 0.9796 | 0.8762 |
| Retrained (labeled + pseudo-labeled rows) | 0.9765 | 0.8922 |

**Observed result:** pseudo-labeling did not improve every metric. ROC-AUC went down slightly (0.9796 to 0.9765), while F1 went up (0.8762 to 0.8922).
