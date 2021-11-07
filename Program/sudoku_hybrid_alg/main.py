import sudoku_hybrid_alg
import time
import pandas as pd
import matplotlib.pyplot as plt
sudokus = pd.read_csv('sudoku_db_50.csv')
y1 = []
y2 = []
solutionHybrid = []
solutionBacktracking = []

print(len(sudokus))
x = [i for i in range(len(sudokus))]

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
plt.plot(x[19:30], y1[19:30],"tab:orange")
plt.plot(x[29:40], y1[29:40],"r")
plt.plot(x[39:50], y1[39:50],"m")
# backtracking
plt.plot([],[],"k--",label = "Backtracking")
plt.plot(x[:10], y2[:10],"g--")
plt.plot(x[9:20], y2[9:20],"y--")
plt.plot(x[19:30], y2[19:30],"--",color="orange")
plt.plot(x[29:40], y2[29:40],"r--")
plt.plot(x[39:50], y2[39:50],"m--")

plt.legend()
plt.show()