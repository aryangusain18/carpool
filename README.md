# DA5401 — Data Analytics Lab

## Assignment 3 — Decision Trees and Random Forests

### Objective

This assignment has two goals:

1. understand how a binary decision tree classifier is built **from first principles**; and
2. understand why combining many randomized trees can improve generalisation and stability.

Problem 1 must be implemented from scratch using **NumPy and pandas only** for the tree algorithm.  
Problem 2 may use scikit-learn.

---

# Files Provided

```text
decision_tree_classification.csv
random_forest_regression.csv
```

---

# Problem 1 — Decision Tree Classifier from Scratch

## Purpose

In this problem, you will implement a binary decision tree classifier yourself rather than using a library implementation.

Your implementation must be **data-agnostic**. The supplied dataset is only one instance used to exercise your code. Public and private tests may call your functions on other datasets satisfying the same input conditions.

## Input Conditions

Your decision-tree implementation may assume that:

- `X` is a pandas `DataFrame`;
- every predictor column in `X` is numerical;
- `X` contains no missing values;
- `y` contains binary labels encoded as `0` and `1`;
- feature names and the number of features are not fixed in advance.

For this problem, use:

```text
decision_tree_classification.csv
```

Target:

```text
target
```

## Restrictions

For the **tree-building, prediction, evaluation, and depth-comparison logic in Problem 1**, use only:

```text
NumPy
pandas
Python standard library
```

Do **not** use:

- `sklearn.tree.DecisionTreeClassifier`;
- any other library implementation of a decision tree;
- sklearn functions that perform splitting, prediction, or evaluation for you.

The objective is to implement and understand the complete decision-tree procedure.

---

## Part A — Gini Impurity

Implement:

```python
def gini_impurity(y):
    """
    Return the Gini impurity of the binary labels y.
    """
```

For an empty input, return `0.0`.

For a pure node, the returned impurity should also be `0.0`.

---

## Part B — Search for the Best Split

At each node, search across **all features** and all valid candidate thresholds.

For a feature:

1. sort its unique values;
2. use the midpoint between each pair of consecutive unique values as a candidate threshold;
3. split observations using the candidate threshold:
4. compute the weighted Gini impurity after the split;
5. compute the Gini gain. 

Implement:

```python
def best_split(X, y):
    """
    Return the best split as a dictionary with exactly:

    {
        "feature": <column name>,
        "threshold": <float>,
        "gain": <float>
    }

    Return None if no valid split with positive gain exists.
    """
```

### Tie-breaking

If two candidate splits have the same gain within normal floating-point precision:

1. choose the feature that appears earlier in `X.columns`

Do not hard-code any feature names or thresholds.

---

## Part C — Recursively Build the Tree

Implement:

```python
def build_tree(
    X,
    y,
    max_depth,
    min_samples_split=2,
    depth=0
):
    """
    Recursively build and return a binary classification tree.
    """
```

Use the following stopping conditions.

Create a leaf if **any** of these is true:

- all observations at the node belong to the same class;
- `depth == max_depth`, when `max_depth` is not `None`;
- the node contains fewer than `min_samples_split` observations;
- `best_split()` returns `None`.

At a leaf, predict the majority class. If both classes have the same count, predict 0 by default. 


### Required Tree Representation

An internal node must have exactly these keys:

```python
{
    "feature": ...,
    "threshold": ...,
    "left": ...,
    "right": ...
}
```

A leaf node must have exactly:

```python
{
    "prediction": 0
}
```

or:

```python
{
    "prediction": 1
}
```

The left child contains observations satisfying:

```text
feature <= threshold
```

and the right child contains observations satisfying:

```text
feature > threshold
```

---

## Part D — Prediction

Implement:

```python
def predict_one(tree, row):
    """
    Predict the class of one observation by traversing
    the tree from the root to a leaf.
    """
```

and:

```python
def predict_tree(tree, X):
    """
    Return a NumPy array containing the prediction
    for every row of X.
    """
```

Your prediction functions must work with trees produced by `build_tree()` and with any numerical DataFrame satisfying the stated input conditions.

---

## Part E — Automatically Compare Tree Depths

A central purpose of this problem is to observe how tree complexity affects training and validation performance.

Use the following candidate depths: [1, 2, 3, 4, 5, 6]

### Data Split

Using NumPy only, create a reproducible random split using a seed based on the **last two digits of your roll number**.

For example, if your roll number ends in `37`, use:

```python
split_seed = 37
rng = np.random.default_rng(split_seed)
```

Use the resulting random permutation of row indices and assign:

- first 70% of rows to training;
- next 15% to validation;
- remaining rows to test.

Use this `split_seed` only for data splitting. Do NOT use the test set while selecting the tree depth.

### Evaluate Every Candidate Depth

Implement:

```python
def evaluate_depths(
    X_train,
    y_train,
    X_validation,
    y_validation,
    max_depth_values,
    min_samples_split=2
):
    """
    Train one tree for every depth in max_depth_values.

    Return a list of dictionaries. Each dictionary must contain:

    {
        "max_depth": ...,
        "train_accuracy": ...,
        "validation_accuracy": ...,
        "tree": ...
    }
    """
```

Accuracy must be calculated using your own predictions:

```text
number of correct predictions / number of observations
```

### Identify Underfitting, Overfitting and the Best Depth

Implement:

```python
def select_depth_behavior(results):
    """
    Given the output of evaluate_depths(), return:

    {
        "underfit_depth": ...,
        "overfit_depth": ...,
        "best_depth": ...
    }
    """
```

Use the following definitions for this assignment.

#### Most underfitting candidate

The candidate with the **lowest training accuracy**.

If tied, choose the shallower tree.

#### Most overfitting candidate

For each candidate calculate:

```text
generalisation_gap =
    train_accuracy - validation_accuracy
```

The candidate with the **largest generalisation gap** is considered the most overfitting candidate.

If tied, choose the deeper tree.

#### Best depth

The candidate with the **highest validation accuracy**.

If tied, choose the shallower tree. The selected `best_depth` must be determined from the training and validation results only.

---

## Part F — Final Evaluation

After selecting `best_depth`:

1. combine the training and validation data;
2. build a new tree using the selected depth;
3. evaluate it once on the untouched test set.

---

# Problem 2 — Random Forest Regression

## Business Context

A maintenance team wants to predict the **duration of a maintenance activity in hours** so that personnel and equipment can be scheduled more effectively.

Use:

```text
random_forest_regression.csv
```

Target:

```text
maintenance_duration_hours
```

The dataset contains:

- numerical and categorical predictors;
- missing values;
- variables measured on different numerical scales; and
- an identifier-like column that should be considered carefully before modelling.

---

## Part A — Prepare the Data

Separate the target from the predictors.

Inspect the columns and decide:

- which columns should be used as predictors;
- which are numerical;
- which are categorical;
- how missing values should be handled.

Use a scikit-learn Pipeline and ColumnTransformer so that the preprocessing is learned from training data only.

---

## Part B — Train/Test Split

Create an:

```text
80% training / 20% test
```

split using a seed based on the **last two digits of your roll number**:

```python
split_seed = int(last_two_digits_of_roll_number)
```

The test set must remain untouched during model comparison.

---

## Part C — Single Decision Tree Baseline

Build a preprocessing + modelling pipeline ending in:

```python
DecisionTreeRegressor(random_state=42)
```

This serves as the single-tree baseline.

Do not tune the baseline tree.

---

## Part D — Compare Random Forest Sizes

Build a preprocessing + modelling pipeline ending in:

```python
RandomForestRegressor(
    random_state=42
)
```

Evaluate the following values:

```python
N_ESTIMATORS_VALUES = [10, 50, 100, 200]
```

For the Random Forest, keep other parameters at their sklearn defaults.

Use:

```python
KFold(
    n_splits=5,
    shuffle=True,
    random_state=split_seed
)
```

on the **training set only**.

Use **MAE** as the cross-validation metric.

For:

- the single decision tree baseline; and
- every Random Forest value of `n_estimators`;

report:

- mean cross-validation MAE;
- standard deviation of cross-validation MAE.

The entire preprocessing + model pipeline must be evaluated inside each fold.

---

## Part E — Select the Random Forest

Choose the Random Forest with the **lowest mean cross-validation MAE**.

If two settings have equal mean MAE within normal floating-point precision, choose the one with fewer trees.

Fit the selected Random Forest pipeline on the full training set.

Evaluate once on the untouched test set using:

- MAE;
- RMSE;
- R².

---

## Part F — Compare Single Tree and Random Forest

Fit the single-tree baseline on the full training set and evaluate it on the same test set using:

- MAE;
- RMSE;
- R².

Compare:

1. the single tree's test performance;
2. the selected Random Forest's test performance;
3. their cross-validation variability.

---

# Report Requirements

Keep `report.md` **as concise as possible**.

## Problem 1

Report only:

- `split_seed` used (last two digits of your roll number);

- training and validation accuracy for every supplied `max_depth`;
- `underfit_depth`;
- `overfit_depth`;
- `best_depth`;
- final test accuracy using the selected depth;
- 2–3 sentences interpreting underfitting and overfitting.

## Problem 2

Report only:

- `split_seed` used (last two digits of your roll number);

- single-tree 5-fold CV MAE mean and standard deviation;
- Random Forest CV MAE mean and standard deviation for `10`, `50`, `100`, and `200` trees;
- selected `n_estimators`;
- single-tree test MAE, RMSE and R²;
- selected Random Forest test MAE, RMSE and R²;
- 2–3 sentences explaining the observed difference between a single tree and the Random Forest.