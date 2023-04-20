#!/usr/bin/python3


class Field:
    def __init__(self,lst_field):
        self.lst_field = lst_field

    def affiche(self):
        print("Liste des fields :",self.lst_field)