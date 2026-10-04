# DA5401 Assignment 5 - Report

Roll number: DA26M002

## Seeds used

- student_seed = 2 (last two digits of the roll number), used for both problems: the student subset sampling and the K-Means initial centroids.

## Problem 1 - K-Means from scratch

- student_seed: 2
- K = 2: total within-cluster squared distance = 4812.935807, silhouette = 0.334103
- K = 3: total within-cluster squared distance = 3059.464210, silhouette = 0.428859
- K = 4: total within-cluster squared distance = 1795.024411, silhouette = 0.507851
- K = 5: total within-cluster squared distance = 1718.212605, silhouette = 0.411893
- K = 6: total within-cluster squared distance = 1668.000257, silhouette = 0.408102
- Selected K: 4 (highest silhouette)
- Cluster sizes for K = 4: 283, 322, 297, 298 (clusters 0 to 3)

## Problem 2 - Hierarchical clustering

- student_seed: 2
- single: silhouette = 0.499912, cluster sizes = 1, 135, 150, 314
- complete: silhouette = 0.703772, cluster sizes = 136, 143, 150, 171
- average: silhouette = 0.703772, cluster sizes = 136, 143, 150, 171
- Selected linkage: complete (complete and average tie exactly, so the tie-break order single, complete, average picks complete)
