import sudoku_hybrid_alg
import time
import pandas as pd
import matplotlib.pyplot as plt
import numpy as np
sudokus = pd.read_csv('sudoku_db_50.csv')
y1 = []
y2 = []
solutionHybrid = []
solutionBacktracking = []
n0list = []
nlist = []

print(len(sudokus))
x = [i for i in range(len(sudokus) - 5)]

for i in range(len(sudokus)):
    start = time.time()
    C_Unsolved = sudokus.Sudoku[i]
    if not C_Unsolved.isnumeric():
        continue
    board = [int(char) for char in C_Unsolved]
    print("hybrid")
    n0,n = sudoku_hybrid_alg.solve(board)
    # sudoku_hybrid_alg.grid_print(board)
    # print(n0,n)
    fin = time.time()
    duration = fin - start
    solution = ''.join([str(e) for e in board])
    solutionList = [solution,n0,n,duration]
    solutionHybrid.append(solutionList)
    n0list.append(n0)
    nlist.append(n)
    y1.append(duration)
    print(f'time required = {duration}')

hybrid = pd.DataFrame(data=solutionHybrid, columns=['Solution','n0','n','time'])
hybrid.to_csv('hybrid.csv', index=False)

for i in range(len(sudokus)):
    start = time.time()
    C_Unsolved = sudokus.Sudoku[i]
    if not C_Unsolved.isnumeric():
        continue
    board = [int(char) for char in C_Unsolved]
    print("backtrack")
    sudoku_hybrid_alg.solve_backtracking(board)
    fin = time.time()
    duration = fin - start
    solution = ''.join([str(e) for e in board])
    solutionList = [solution, duration]
    solutionBacktracking.append(solutionList)
    y2.append(duration)
    print(f'time required = {duration}')

backtracking = pd.DataFrame(data=solutionBacktracking, columns=['Solution','time'])
backtracking.to_csv('backtracking.csv', index=False)

# hybrid
plt.plot([],[],"k",label = "Hybrid")
plt.plot(x[:10], y1[:10],"g")
plt.plot(x[9:20], y1[9:20],"y")
# backtracking
plt.plot([],[],"k--",label = "Backtracking")
plt.plot(x[:10], y2[:10],"g--")
plt.plot(x[9:20], y2[9:20],"y--")

plt.title("Easy - Medium")
plt.legend()
plt.show()

# hybrid
plt.plot([],[],"k",label = "Hybrid")
plt.plot(x[19:30], y1[19:30],"tab:orange")
plt.plot(x[29:40], y1[29:40],"r")
plt.plot(x[39:50], y1[39:50],"m")
# backtracking
plt.plot([],[],"k--",label = "Backtracking")
plt.plot(x[19:30], y2[19:30],"--",color="orange")
plt.plot(x[29:40], y2[29:40],"r--")
plt.plot(x[39:50], y2[39:50],"m--")

plt.title("Hard - Expert - Evil")
plt.legend()
plt.show()

# ============================ Before and After PnP ============================

######### Easy #########

x1 = np.arange(len(x[:10])) 
width = 0.25  

fig, ax = plt.subplots()
rects1 = ax.bar(x1 - width/2, n0list[:10], width, label='n0')
rects2 = ax.bar(x1 + width/2, nlist[:10], width, label='n')

ax.set_ylabel('Empty Squares')
ax.set_title('Difficulty: Easy')
ax.set_xticks(x1)
ax.set_xticklabels(x[:10])
ax.legend()

ax.bar_label(rects1, padding=3)
ax.bar_label(rects2, padding=3)

fig.tight_layout()

plt.show()

######### Medium #########

x1 = np.arange(len(x[10:20]))  
width = 0.25 

fig, ax = plt.subplots()
rects1 = ax.bar(x1 - width/2, n0list[10:20], width, label='n0')
rects2 = ax.bar(x1 + width/2, nlist[10:20], width, label='n')

ax.set_ylabel('Empty Squares')
ax.set_title('Difficulty: Medium')
ax.set_xticks(x1)
ax.set_xticklabels(x[10:20])
ax.legend()

ax.bar_label(rects1, padding=3)
ax.bar_label(rects2, padding=3)

fig.tight_layout()

plt.show()

######### Hard #########

x1 = np.arange(len(x[20:30]))  
width = 0.25 

fig, ax = plt.subplots()
rects1 = ax.bar(x1 - width/2, n0list[20:30], width, label='n0')
rects2 = ax.bar(x1 + width/2, nlist[20:30], width, label='n')

ax.set_ylabel('Empty Squares')
ax.set_title('Difficulty: Hard')
ax.set_xticks(x1)
ax.set_xticklabels(x[20:30])
ax.legend()

ax.bar_label(rects1, padding=3)
ax.bar_label(rects2, padding=3)

fig.tight_layout()

plt.show()

######### Expert #########

x1 = np.arange(len(x[30:40]))  
width = 0.25 

fig, ax = plt.subplots()
rects1 = ax.bar(x1 - width/2, n0list[30:40], width, label='n0')
rects2 = ax.bar(x1 + width/2, nlist[30:40], width, label='n')

ax.set_ylabel('Empty Squares')
ax.set_title('Difficulty: Expert')
ax.set_xticks(x1)
ax.set_xticklabels(x[30:40])
ax.legend()

ax.bar_label(rects1, padding=3)
ax.bar_label(rects2, padding=3)

fig.tight_layout()

plt.show()

######### Evil #########

x1 = np.arange(len(x[40:50]))  
width = 0.25 

fig, ax = plt.subplots()
rects1 = ax.bar(x1 - width/2, n0list[40:50], width, label='n0')
rects2 = ax.bar(x1 + width/2, nlist[40:50], width, label='n')

ax.set_ylabel('Empty Squares')
ax.set_title('Difficulty: Evil')
ax.set_xticks(x1)
ax.set_xticklabels(x[40:50])
ax.legend()

ax.bar_label(rects1, padding=3)
ax.bar_label(rects2, padding=3)

fig.tight_layout()

plt.show()