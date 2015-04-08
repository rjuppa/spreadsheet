This was a test in PHP I got on job interview.

Simple Spreadsheet
==================

Introduction
------------

Please attempt your solution in PHP, using object-oriented approach. Solve the
tasks as if you were writing real production code; if you don't have time to do
things the way you would like to, then enclose a comment describing how you
would improve your work if you were working on it in a professional environment.
We are particularly interested to see code that is readable and robust.

The purpose of this exercise is to design and model a simple spreadsheet. You
should spend no more than about an evening doing this assessment; you are not
required to complete it. However, any code that you submit should be in a state
where it can be run and the output examined. You may choose to provide comments
or notes with your code that explain what it is doing; if you do not complete
the exercise, you can also supply notes on how you would expand on your work to
fulfil the description.

The application packaging and user interface are not important; use of the
console for simple input and output is perfectly sufficient.


The Spreadsheet Application
---------------------------

The application consists of a single spreadsheet containing a small, fixed
number of cells; cells can contain numerical values or formulae that operate on
the values. The spreadsheet has methods that allow values to be set and queried.
The core application description is as follows:

- there is a single spreadsheet
- the spreadsheet has eight columns labelled A to H and ten rows
labelled 1 to 10
- spreadsheet cells are identified letter-number combinations, such as
A1, D4 and H10
- spreadsheet cells may be empty or may contain floating-point decimal values
- cells are empty by default
- empty cells print out with the string value "" (the empty string) but when
  used in calculations have the numerical value 0 (zero)

Here is an example of a spreadsheet populated with some values:

            A       B       C       D       E
         1  10.40   14.80
         2   3.14    8.90
         3                  19.00   81.00
         4
         5
         6
         7  17.00
         8          99.45
         9
        10


Task 1: Create the Core Classes
-------------------------------

Write a class to represent a spreadsheet cell. It will require methods that
allow it to be assigned a numerical value, to be emptied, and to return both a
string representation and a numerical representation. Write test code that tests
the behaviour of the cell class.

Write a class to represent the spreadsheet, using the class you have written
that represents cells. The spreadsheet class will need methods that allow cells
identified by their names (e.g. A1 or D4) to be assigned numerical values or
emptied, as well as queried for the values they contain. The spreadsheet class
will also need a method that allows it to be printed out in a format similar to
the example shown above. Write test code that tests the behaviour of the
spreadsheet class.


Task 2: Implement Ranges
------------------------

Calculations are done on ranges of cells; ranges are inclusive rectangular
regions of the spreadsheet that are expressed in the format
TOP_LEFT:BOTTOM_RIGHT,
for example A1:C6 or D7:H9.

Enhance your work so that ranges can be requested using the format expressed.
How would you model this in an object-oriented way?


Task 3: Implement Formulae
--------------------------

Formulae (i.e. calculations) are performed on ranges of cells. Some
examples are:

- SUM: sums all of the numerical values in the given range
- MAX: finds the maximum numerical value in the given range (ignoring
empty cells)
- MIN: finds the minimum numerical value in the given range (ignoring
empty cells)

Enhance your work so that the above calculations can be performed on ranges. How
would you expand upon your work so far using object-oriented programming
principles to achieve this?


Task 4: Allow Formulae as Cell Values
-------------------------------------

When formulae appear as actual values in a spreadsheet cell, they take the form
=FUNCTION(RANGE) where FUNCTION is one of the formulae listed in Task 3 and
RANGE is expressed as in Task 2.

Enhance your work so that formulae expressed in this way can also be cell values
(i.e. in addition to being empty or having floating-point numerical values). It
is important to note that when a cell containing a formula is printed out, it
should print out the result of the calculation (i.e. a number) rather than the
formula. So, for example, a cell that contains the formula =SUM(A1:A7) in cell
A9 of the example spreadsheet shown above would display the number 48.78 when
printed out.

