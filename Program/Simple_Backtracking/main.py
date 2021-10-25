import backtracking
import board

if backtracking.solve(board.grid,0,0):
    for i in range(9):
        for j in range(9):
            print(board.grid[i][j], end=" ")
        print()
else:
    print("No Solution For This Sudoku")