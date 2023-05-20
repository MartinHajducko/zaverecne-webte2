import sys
from sympy import *
from sympy.parsing.latex import parse_latex

def compare_expressions(expr1, expr2):
    sym_expr1 = parse_latex(expr1)
    sym_expr2 = parse_latex(expr2)
    
    # Use SymPy's simplify function to compare the expressions
    return simplify(sym_expr1) == simplify(sym_expr2)


if __name__ == "__main__":
    latex_expr1 = sys.argv[1]
    latex_expr2 = sys.argv[2]
    result = compare_expressions(latex_expr1, latex_expr2)
    print(result)
