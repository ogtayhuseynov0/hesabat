"""Export to CSV."""
import sys
import os
import csv
from dbfread import DBF

table = DBF(sys.argv[1],encoding='iso-8859-1')
if os.path.isfile('csv/flkart.csv'):
    os.remove('csv/flkart.csv')
with open('csv/flkart.csv', "w", newline='',encoding='iso-8859-1') as csv_file:
        writer = csv.writer(csv_file, delimiter=',')
        #writer.writerow(table.field_names)
        for record in table:
            writer.writerow(list(record.values()))

if os.path.isfile('csv/flkartx.csv'):
    os.remove('csv/flkartx.csv')
table = DBF(sys.argv[2],encoding='iso-8859-1')
with open('csv/flkartx.csv', "w", newline='',encoding='iso-8859-1') as csv_file:
        writer = csv.writer(csv_file, delimiter=',')
        #writer.writerow(table.field_names)
        for record in table:
            writer.writerow(list(record.values()))
