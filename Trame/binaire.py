#!/usr/bin/python3

import struct
import datetime
from decimal import	Decimal

def read_size_trame(Dfic):
    with open(Dfic, 'rb') as bin:
        binaire = bin.read()

        size = binaire[24:28]

        int_size = struct.unpack('>i', size)[0]
        int_size = int_size + 28

        return int_size









def read_binary_file(Dfic) :
    with open(Dfic, 'rb') as bin:
        binaire = bin.read() #lit le fic binaire
        return binaire


# def read_mac_address(Doctets):
#     with open(Doctets, 'rb') as bin:
#         bin.seek(28) # position de départ
#         mac_octets = bin.read(6) # lire 6 octets

#         bin.seek(34)
#         mac2_octets = bin.read(6)
#         return mac_octets, mac2_octets

# def convert_to_hex(Doctet1,Doctet2):

#     hexa = [Doctet1.hex(), Doctet2.hex()]

#     return hexa


def convert_binary_hex(DlstO) :
    hexa = DlstO.hex()
    return hexa

def convert_to_float_double(Doctets):
    flotant = struct.unpack('>d', Doctets)[0]

    return flotant

def convert_to_ip(Doctets):
    lst = []

    for i in range(0,4,1):
        lst.append(Doctets[i:i+1])

    lst_int = []
    for i in lst:
        integer = int.from_bytes(i, byteorder="big",signed=False)
        str_int = str(integer)
        lst_int.append(str_int)

    ip = ".".join(lst_int)
        


    return ip   

def mac_address(mac):
    
    str_mac = str(mac)
    result = ''

    for i in range(0,len(str_mac),2):
        result += str_mac[i:i+2] + ":"

    return (result.strip(":"))

def date_affiche(date):
    date_base = datetime.datetime(1970,1,1,0,0,0)
    date_data = datetime.timedelta(seconds=date)

    date_result = date_base + date_data

    return(date_result.strftime("%d:%m:%Y"))

if __name__ == '__main__' :

    #Première méthode, on ouvre tout le fichier on choisis ce que l'ont veut décoder (pas finit on peut organiser ça en fonctions), pour l'instant tout en phase de test
    liste_octets = read_binary_file("C:/Users/mattg/Desktop/Trame/ethernet.result_data_")
    date = liste_octets[8:16]
    mac = liste_octets[28:34]
    mac2 = liste_octets[34:40]
    ip = liste_octets[54:58]
    field1 = convert_binary_hex(liste_octets[2:3])
    print(field1)
    ip2 = liste_octets[58:62]
    ip = convert_to_ip(ip)
    ip2 = convert_to_ip(ip2)
    mac = convert_binary_hex(mac)
    mac2 = convert_binary_hex(mac2)
    mac = mac_address(mac)
    mac2 = mac_address(mac2)
    date = convert_to_float_double(date)
    date = date_affiche(date)
    print(date, mac, mac2, ip, ip2)


    taille = read_size_trame("C:/Users/mattg/Desktop/Trame/ethernet.result_data_")
    print(taille)


    # #Deuxième méthode ici on ouvre le fichier juste pour l'@Mac et on décode les 2 pour ensuite les mettres dans une liste(marche + utilisable)
    # mac_addresse1, mac_addresse2 = read_mac_address("C:/Users/Matt/Desktop/Trame/ethernet.result_data_")
    # #print(mac_addresse1)
    # liste_mac_hex = convert_to_hex(mac_addresse1,mac_addresse2)
    # print(liste_mac_hex)


