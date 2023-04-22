#!/usr/bin/python3

import struct
import datetime
from decimal import	Decimal


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

    return(date_result.strftime("%A:%d:%b:%m:%Y:%H:%M:%S"))

def convert_to_dec(binary):

    int_size = struct.unpack('>i', binary)[0]

    return int_size

def convert_fields(field):
    int_field = int.from_bytes(field,byteorder='big',signed=False)
    return int_field

# def convert_fields_by_bits(binaire,debut,fin):
#     if not isinstance(binaire, bytes) or len(binaire) != 2:
#         raise ValueError("L'entrée doit être un nombre binaire de 2 octets sous la forme b'\\x00\\xb8'")

#     liste_bits = [int(bit) for octet in binaire for bit in format(octet, '08b')]

#     bit_convertie = int.from_bytes(liste_bits[debut:fin],byteorder='big',signed=False)

#     return bit_convertie

def convert_field_hex(field):
    hex_field = field.hex()
    return hex_field

def convert_fields_by_bits(octd,octf,bitd,bitf,binary):
    n = octf - octd
    dec = convert_fields(binary)
    dec_bin = str(bin(dec))[2:]
    dec_bin = dec_bin.zfill(n*8)
    bit = dec_bin[bitd:bitf]
    nombre = int(bit,2)

    return nombre




