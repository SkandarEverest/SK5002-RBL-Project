import time
import pandas as pd
import matplotlib.pyplot as plt
sudokus = pd.read_csv('sudoku_db_50.csv')
y = []
board = [i for i in range(81)]
n0 = 0

# set for every possible number (1-9)
nlist = {i for i in range(1, 10)}


# print the sudoku board
def grid_print(b):
    # iterate through every square
    for row in range(9):
        for col in range(9):
            print(b[9*row + col], end='  ')
        print()


# return set of all used number in the small box
def small_box_set(row, col):
    # determine starting index for the loop
    row_start = (row // 3) * 3
    col_start = (col // 3) * 3
    box = []
    # loop through the 3x3 box
    for r in range(row_start, row_start + 3):
        for c in range(col_start, col_start + 3):
            box.append(board[9*r + c])
    # convert box to set
    return set(box)


# outputs a set of all candidate in 1 square
def possible_set(row, col):
    # if the tile not zero then return empty set (len = 0)
    if board[9*row + col] != 0:
        return {}
    # row_set is the set of used number in the row
    row_set = set(board[9*row:(9*row)+9])
    # col_set is the set of used number in the col
    col_set = {board[(i * 9) + col] for i in range(9)}
    # return set of all possible number for the tile
    return ((nlist - row_set) - col_set) - small_box_set(row, col)


# inverse board (possible sets for every square)
def inv_board():
    candidates = []
    for row in range(9):
        for col in range(9):
            ps = list(possible_set(row, col))
            if len(ps) == 0:
                candidates.append([])
            else:
                candidates.append(ps)
    return candidates


def naked_singles():
    for row in range(9):
        for col in range(9):
            ps = possible_set(row, col)
            # if the possible_set only has 1 element that is the solution
            if len(ps) == 1:
                solution = ps.pop()
                board[9*row + col] = solution


def hidden_singles():
    candidates_set = inv_board()
    # check for every number
    for num in nlist:
        # when getting into new number set count to 0
        count = 0
        loc = 0
        # check every row and col
        for row in range(9):
            for col in range(9):
                row_count = [0 for __ in range(9)]
                box_count = 0
                row_loc = 0
                box_loc = 0

                # hidden singles in col
                if row == 0:
                    for j in range(9):
                        if num in candidates_set[col+9*j]:
                            row_count[col] += 1
                            row_loc = col + 9*j
                    # if found fill the said grid
                    if row_count[col] == 1:
                        board[row_loc] = num
                        return

                # hidden singles in row
                if num in candidates_set[9*row + col]:
                    count += 1
                    loc = 9*row + col

                # hidden singles in box
                if row in [0, 3, 6] and col in [0, 3, 6]:
                    for r in range(row, row + 3):
                        for c in range(col, col + 3):
                            if num in candidates_set[9*r + c]:
                                box_count += 1
                                box_loc = 9*r + c
                    if box_count == 1:
                        board[box_loc] = num
                        return

        if count == 1:
            board[loc] = num
            return


# backtracking algorithm
def backtracking(row, col):
    # if already at the last square (index 80) then return True
    if (row * 9) + col >= len(board):
        return True
    # advance to the next row
    if col >= 9:
        row += 1
        col = 0
    # if the current square is filled then go to the next square
    if board[(row * 9) + col] > 0:
        return backtracking(row, col + 1)
    # check every possible number and assign one by one
    ps = possible_set(row, col)
    for num in ps:
        board[(row * 9) + col] = num
        # check the next square if it continues until finish then terminate
        if backtracking(row, col + 1):
            return True
        # if not then remove the previous assumption
        board[(row * 9) + col] = 0
    return False


def main_pnp():
    n0 = board.count(0)
    print(f'empty square before PnP= {n0}')
    nzero = n0
    improve = True
    while improve:
        n0 = board.count(0)
        naked_singles()
        hidden_singles()
        n = board.count(0)
        # if theres is less empty square after, go back to the start of the loop
        improve = n < n0
    print(f'empty square after PnP = {n}')
    return nzero, n


def solve(b):
    global board 
    board = b
    n0,n = main_pnp()
    # if the PnP didn't solve the puzzle do backtracking
    if board.count(0) > 0:
        if not backtracking(0, 0) : 
            print('No valid solution found!')
    return n0,n


def solve_backtracking(b):
    global board 
    board = b
    if backtracking(0, 0):
        # print board if solved
        return
    else:
        print('No valid solution found!')


if __name__ == '__main__':
    x = [i for i in range(len(sudokus))]
    for i in range(len(sudokus)):
        start = time.time()
        C_Unsolved = sudokus.Sudoku[i]
        board = [int(char) for char in C_Unsolved]
        print()
        solve()
        grid_print(board)
        fin = time.time()
        duration = fin - start
        y.append(duration)
        print(f'time required = {duration}')
