import sys

from pulp import *
import pandas as pd

# write a scaper before hand
data = pd.read_csv('livros.csv', encoding="iso-8859-1")
problem_name = 'BuyingBestsellers'
hours_week_read = 5
pages_per_hour = 60
period_reading = 12


def optimize_bestseller_reading(hours, pages, period):

    hours_week_read = hours
    pages_per_hour = pages
    period_reading = period

    print(hours_week_read)
    print(pages_per_hour)
    print(period_reading)

    # create the LP object, set up as a maximization problem --> since we want to maximize the number of books we
    # read in a year
    prob = LpProblem(problem_name, LpMaximize)

    # create decision - yes or no to buy the book?
    decision_variables = []
    weights_list = []
    for rownum, row in data.iterrows():
        variable = str('x' + str(rownum))
        variable = pulp.LpVariable(str(variable), lowBound=0, upBound=1, cat='Integer')  # make variables binary
        decision_variables.append(variable)
        weights_list.append(row['weight'])

    print("Total number of decision_variables: " + str(len(decision_variables)))
    print("Total number of weights_list: " + str(weights_list))


	#create optimization function
    total_books = ""	
    for i, book in enumerate(decision_variables):
        total_books += book
        
    prob += total_books
    print("Optimization function: " + str(total_books))

    # create constrains - there are only 365 days
    total_pages_needs_to_read = ""
    for rownum, row in data.iterrows():
        for i, schedule in enumerate(decision_variables):
            if rownum == i:
                formula = row['pages'] * schedule
                total_pages_needs_to_read += formula

    total_pages_can_read = (period_reading * 4) * hours_week_read * pages_per_hour

    print(row['weight'])
    exit

    prob += (total_pages_needs_to_read <= total_pages_can_read/row['weight'])

    # now run optimization
    optimization_result = prob.solve()
    assert optimization_result == LpStatusOptimal
    prob.writeLP(problem_name + ".lp")
    print("Status:", LpStatus[prob.status])
    # print("Optimal Solution to the problem: ", value(prob.objective))
    print("Individual decision_variables: ")
    for v in prob.variables():
        print(v.name, "=", v.varValue)

    # transform the data back

    #########################
    # Format the Results

    # reorder results
    variable_name = []
    variable_value = []

    for v in prob.variables():
        variable_name.append(v.name)
        variable_value.append(v.varValue)

    df = pd.DataFrame({'variable': variable_name, 'value': variable_value})
    for rownum, row in df.iterrows():
        value = re.findall(r'(\d+)', row['variable'])
        df.loc[rownum, 'variable'] = int(value[0])

    df = df.sort_index(key=0)

    # append results
    for rownum, row in data.iterrows():
        for results_rownum, results_row in df.iterrows():
            if rownum == results_row['variable']:
                data.loc[rownum, 'decision'] = results_row['value']

    # export data-table
    data.to_csv('reading_list.csv', index=False)
    print("Your Reading List is ready")


if __name__ == "__main__":
    if sys.argv[1] != '0' and sys.argv[2] != '0' and sys.argv[2] != '0':
        hours = int(sys.argv[1])
        pages = int(sys.argv[2])
        period = int(sys.argv[3])
    else:
        hours = 5
        pages = 60
        period = 12
    optimize_bestseller_reading(hours, pages, period)
