#!/usr/bin/python3

import struct
import datetime
from decimal import	Decimal
from dic import *


def convert_binary_hex(DlstO) : #fonction pour convertir binaire en héxa
    hexa = DlstO.hex() #appel de la fonction héxa
    return hexa

def convert_to_float_double(Doctets): #fonction pour convertir le binaire en double
    flotant = struct.unpack('>d', Doctets)[0] #appel de la fonction struct.unpack pour convertir le binaire en double

    return flotant


def convert_to_ip(Doctets): #focntion pour obtenir l'adresse IP
    lst = [] #crée une liste vide

    for i in range(0,4,1): #sépare chaque octets
        lst.append(Doctets[i:i+1])

    lst_int = [] #crée une nouvelle liste vide ou l'on va stocker chaque nombre
    for i in lst: #pour chaque octets on le décode puis l'ajoute à lst_int
        integer = int.from_bytes(i, byteorder="big",signed=False) #fonction pour décoder le binaire en entier
        str_int = str(integer) #convertir en string pour le concatener
        lst_int.append(str_int) #ajoute à lst_int

    ip = ".".join(lst_int) #on concatène tout les nombres ensembles avec un "." pour crée l'adresse ip
        
    return ip   

def mac_address(mac): #fonction pour concaténer l'adresse MAC
    
    str_mac = str(mac) #converti l'adresse MAC en string
    result = '' #crée une chaine vide

    for i in range(0,len(str_mac),2): #tout les 2 octets on ajoute à resulte les 2 octets + ":"
        result += str_mac[i:i+2] + ":"

    return (result.strip(":")) #retourne le résultat en enlevant ":" à la fin

def date_affiche(date): #fonction pour afficher la date 
    date_base = datetime.datetime(1970,1,1,0,0,0) # crée une variable pour stocker la date à partir de la date du début
    date_data = datetime.timedelta(seconds=date) # crée une variable pour stocker la date à ajouter

    date_result = date_base + date_data #ajoute les 2 dates ensembles

    return(date_result.strftime("%A:%d:%b:%m:%Y:%H:%M:%S.%f")) #retourne la date avec l'affiche adéquat

def PacketDate_affiche(date): # fonction pour afficher le PacketDate
    date_base = datetime.datetime(2000,1,1,12,0,0) # crée une variable pour stocker la date à partir de la date du début
    date_data = datetime.timedelta(seconds=date) # crée une variable pour stocker la date à ajouter

    date_result = date_base + date_data # ajoute les 2 dates ensembles

    return(date_result.strftime("%A:%d:%b:%m:%Y:%H:%M:%S.%f")) ## retourne la date avec l'affiche adéquat

def convert_to_dec(binary): #fonction pour convertir le binaire en décimal

    int_size = struct.unpack('>i', binary)[0] #convertit grâce à struct le binaire en entier

    return int_size

def convert_fields(field): #fonction pour convertir le binaire en décimal, mais pour les fiels car struct ne prend pas en entrée par exemple 5 bits
    int_field = int.from_bytes(field,byteorder='big',signed=False) # cette fois-ci on utilise int.from-bytes pour décoder
    return int_field


def convert_field_hex(field): # fonction pour convertir le binaire en héxadécimal
    hex_field = field.hex() # converti le binaire en hex
    return hex_field


def convert_fields_by_bits(octd,octf,bitd,bitf,binary): #fonction pour convertir un bit en décimal
    n = octf - octd # calcule le nombre d'octets
    dec = convert_fields(binary) #converti le binaire en décimal
    dec_bin = str(bin(dec))[2:] #converti en binaire en forme de 000000000
    dec_bin = dec_bin.zfill(n*8) #remplie pour qu'il y ait le nombre adéquat de bits
    bit = dec_bin[bitd:bitf] # prend le bit adéquat
    nombre = int(bit,2) # converti le bit en décimal

    return nombre


def check_FT(nb,numFT):
    #Si le numéro de la FT est égal à 1 alors on regarde dans le dictionnaire de FT1
    if numFT == 1:
        for cle,val in FT1.items():
            if nb == val:
                nb = str(nb) + "(" + cle + ")"
    #Ainsi de suite
    if numFT == 2:
        for cle,val in FT2.items():
            if nb == val:
                nb = str(nb) + "(" + cle + ")"
    
    if numFT == 3:
        for cle,val in FT3.items():
            if nb == val:
                nb = str(nb) + "(" + cle + ")"

    if numFT == 4:
        for cle,val in FT4.items():
            if nb == val:
                nb = str(nb) + "(" + cle + ")"

    if numFT == 5:
        for cle,val in FT5.items():
            
            if nb == val:
                nb = str(nb) + "(" + cle + ")"

    if numFT == 7:
        for cle,val in FT7.items():
            if nb == val:
                nb = str(nb) + "(" + cle + ")"

    if numFT == 0:
        for cle,val in FT0.items():
            if nb == val:
                nb = str(nb) + "(" + cle + ")"

    if numFT == 6:
        for cle,val in FT6.items():
            if nb == cle:
                nb = str(nb) + "(" + val + ")"
    
    if numFT == "IP":
        for cle,val in IP.items():
            if nb == cle:
                nb = str(nb) + "(" + val + ")"
    
    if numFT == "MAC":
        for cle,val in MAC.items():
            if nb == cle:
                nb = str(nb) + "(" + val + ")"

    return nb
