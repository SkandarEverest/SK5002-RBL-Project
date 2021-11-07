import pandas as pd
# cities = pd.DataFrame(data=[['Sacramento', 'California'], ['Miami', 'Florida']], columns=['City', 'State'])
# cities.to_csv('cities.csv', index=False)

sudokus = pd.read_csv('sudoku_db_50.csv')

for i in range(55):
    C_Unsolved = sudokus.Sudoku[i]
    if not C_Unsolved.isnumeric():
        continue
    print(C_Unsolved)
    # print(i)