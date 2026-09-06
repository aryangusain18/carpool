DA5401 Assignment 3 Report
Roll No: DA26M002

Problem 1 - Decision Tree Classifier

split_seed = 2

```
Depth   Train Acc   Val Acc
1       0.6490      0.5333
2       0.6592      0.5238
3       0.6939      0.5905
4       0.7429      0.6571
5       0.7837      0.6571
6       0.8347      0.6381
```

underfit_depth = 1
overfit_depth  = 6
best_depth     = 4
final test accuracy (depth 4) = 0.6381

At depth 1 the tree is too simple, so train and validation accuracy are both low and close together, which is underfitting. As depth increases train accuracy keeps going up but validation accuracy peaks around depth 4-5 and drops a bit by depth 6, so the train-validation gap is biggest at depth 6, which is overfitting. Depth 4 is chosen as the best depth because it matches the top validation accuracy of depth 5 with a simpler tree.

Problem 2 - Random Forest Regression

split_seed = 2

5-fold CV MAE:
```
Model           Mean CV MAE   Std CV MAE
single tree     11.2171       0.6284
RF (10 trees)   8.1338        0.6063
RF (50 trees)   7.6691        0.5279
RF (100 trees)  7.5332        0.5710
RF (200 trees)  7.5568        0.5883
```

selected n_estimators = 100

Test set results:
```
Model           MAE       RMSE      R2
single tree     11.5883   14.6317   0.1059
random forest   7.4563    9.3880    0.6319
```

A single decision tree with no depth limit overfits the training data, so its CV error is much higher than any random forest setting and its test R2 is very low. Averaging 100 trees in the random forest cuts the test MAE almost in half (11.59 to 7.46) and raises R2 to 0.63. The standard deviation across folds is only a bit lower for the forest, so most of the improvement is from lower average error rather than more stable folds.
