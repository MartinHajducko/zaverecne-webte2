import sys
from sympy import *
from sympy.parsing.latex import parse_latex

def simplify_expression(expr):
    sym_expr = parse_latex(expr)
    simplified_expr = simplify(sym_expr)
    return str(simplified_expr)

if __name__ == "__main__":
    user_answer = sys.argv[1]
    correct_answer = sys.argv[2]

    simplified_user_answer = simplify_expression(user_answer)
    simplified_correct_answer = simplify_expression(correct_answer)

    print(simplified_user_answer)
    print(simplified_correct_answer)
