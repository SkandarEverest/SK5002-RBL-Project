# board easy
board = [1, 0, 5, 0, 0, 2, 0, 8, 4,
         0, 0, 6, 3, 0, 1, 2, 0, 7,
         0, 2, 0, 0, 5, 0, 0, 0, 0,
         0, 9, 0, 0, 1, 0, 0, 0, 0,
         8, 0, 2, 0, 3, 6, 7, 4, 0,
         3, 0, 7, 0, 2, 0, 0, 9, 0,
         4, 7, 0, 0, 0, 8, 0, 0, 1,
         0, 0, 1, 6, 0, 0, 0, 0, 9,
         2, 6, 9, 1, 4, 0, 3, 7, 0]

# board medium
# board = [0, 3, 0, 6, 0, 0, 9, 8, 4,
#          6, 0, 0, 8, 3, 0, 2, 0, 0,
#          8, 2, 0, 5, 0, 0, 6, 0, 3,
#          2, 0, 0, 3, 0, 0, 0, 0, 0,
#          0, 9, 0, 0, 0, 7, 0, 0, 0,
#          0, 5, 0, 0, 8, 0, 0, 9, 0,
#          0, 0, 0, 0, 1, 0, 0, 7, 8,
#          1, 0, 0, 0, 6, 3, 0, 0, 0,
#          0, 0, 4, 0, 2, 0, 0, 6, 0]

# set for every possible number (1-9)
nlist = {i for i in range(1, 10)}


# print the sudoku board
def board_print():
    for row in range(9):
        for col in range(9):
            print(board[9*row + col], end='  ')
        print()


# return set of all used number in the small box
def small_box(row, col):
    row_start = (row // 3) * 3
    col_start = (col // 3) * 3
    box = []
    for r in range(row_start, row_start + 3):
        for c in range(col_start, col_start + 3):
            box.append(board[9*r + c])
    return set(box)


# check all the possible number in 1 tile
def possible_set(row, col):
    # if the tile not zero then return empty set (len = 0)
    if board[9*row + col] != 0:
        return {}
    # row_set is the set of used number in the row
    row_set = set(board[9*row:(9*row)+9])
    # row_set is the set of used number in the col
    col_set = {board[(i * 9) + col] for i in range(9)}

    # return set of all possible number for the tile
    return ((nlist - row_set) - col_set) - small_box(row, col)


def inv_board():
    for row in range(9):
        for col in range(9):
            ps = possible_set(row, col)
            print(ps, end='')
        print()


def naked_singles():
    for row in range(9):
        for col in range(9):
            ps = possible_set(row, col)
            if len(ps) == 1:
                ns = ps.pop()
                # print(f'row{row} col{col} is a naked single! Value = {ns}')
                board[9*row + col] = ns


# print test board and inverse board (all candidate number)
def main_test_print():
    print(board[0:9])
    board_print()
    inv_board()


# testing naked single for easy board
def main_naked_single():
    board_print()
    naked_singles()
    naked_singles()
    naked_singles()
    naked_singles()
    print()
    board_print()


if __name__ == '__main__':
    main_naked_single()
