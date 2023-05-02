#!/usr/bin/python3

import mysql.connector
from fonctions import *
from field import *


if __name__ == '__main__': 
    
    connection = mysql.connector.connect(host='localhost',
                                        database='thales',
                                        user='root',
                                        password='adminthales')

    with open("./ethernet.result_data", 'rb') as binary: #On ouvre le fichier binaire

        trame = 0 #set la variable trame à 0
        
        fic = binary.read() #fic sera égal au contenue du fichier binaire

        state = True #définit un état en true

        cpt = 0 #on définit un compteur égal à 0

        while state == True: #tant que l'état est égal à TRUE alors 
            
            field1 = convert_field_hex(fic[trame+40:trame+42]) #lit le premier field pour déterminer le type de trame
            liste_field = [] #crée une liste vide

            if field1 == '0800': #si le field est égal à 0800 alors
                date = date_affiche(convert_to_float_double(fic[trame+8:trame+16])) #lit la date
                mac = check_FT(mac_address(convert_binary_hex(fic[trame+28:trame+34])),"MAC") #lit la première addresse MAC
                mac2 = check_FT(mac_address(convert_binary_hex(fic[trame+34:trame+40])),"MAC") #lit la deuxième adresse MAC
                ip = check_FT(convert_to_ip(fic[trame+54:trame+58]),"IP") #lit la première addresse IP
                ip2 = check_FT(convert_to_ip(fic[trame+58:trame+62]),"IP") #lit la deuxième addresse IP
                b3 = convert_fields(fic[trame+16:trame+20]) #lit le bench3
                b5 = check_FT(convert_fields_by_bits(19,23,12,16,fic[trame+19:trame+23]),0) #bench5

                liste_field.append(field1) #field1
                liste_field.append(convert_fields(fic[trame+42:trame+44])) #field2 (décode en décimal)
                liste_field.append(convert_fields(fic[trame+44:trame+46])) #field3 (décode en décimal)
                liste_field.append(convert_fields(fic[trame+46:trame+48])) #field4 (décode en décimal)
                liste_field.append(convert_fields(fic[trame+48:trame+50])) #field5 (décode en décimal)
                liste_field.append(convert_fields(fic[trame+50:trame+51])) #field6 (décode en décimal)
                liste_field.append(convert_fields(fic[trame+51:trame+52])) #field7 (décode en décimal)
                liste_field.append(convert_fields(fic[trame+62:trame+64])) #field9 (décode en décimal)
                liste_field.append(convert_fields(fic[trame+64:trame+66])) #field10 (décode en décimal)
                liste_field.append(convert_fields(fic[trame+66:trame+68])) #field11 (décode en décimal)
                liste_field.append(check_FT(convert_fields_by_bits(70,72,3,4,fic[trame+70:trame+72]),7)) #field14 (décode en décimal) puis regarde ça FT
                liste_field.append(convert_fields_by_bits(70,72,5,8,fic[trame+70:trame+72])) #field16 (décode en décimal)
                liste_field.append(check_FT(convert_fields_by_bits(70,72,8,11,fic[trame+70:trame+72]),5)) #field17 (décode en décimal) puis regarde ça FT
                liste_field.append(check_FT(convert_fields_by_bits(70,72,11,16,fic[trame+70:trame+72]),2)) #field18 (décode en décimal) puis regarde ça FT
                liste_field.append(convert_fields_by_bits(72,74,2,16,fic[trame+72:trame+74])) #field20 (décode en décimal)
                liste_field.append(convert_fields(fic[trame+74:trame+76]))#field21 (décode en décimal)
                liste_field.append(convert_fields_by_bits(76,77,4,5,fic[trame+76:trame+77])) #field23 (décode en décimal)
                liste_field.append(convert_fields_by_bits(76,77,6,7,fic[trame+76:trame+77])) #field25 (décode en décimal)
                liste_field.append(convert_fields_by_bits(76,77,7,8,fic[trame+76:trame+77])) #field26 (décode en décimal)
                liste_field.append(check_FT(convert_fields_by_bits(77,78,2,8,fic[trame+77:trame+78]),3)) #field28 (décode en décimal) puis regarde ça FT
                liste_field.append(check_FT(convert_fields_by_bits(78,80,0,6,fic[trame+78:trame+80]),4)) #field29 (décode en décimal) puis regarde ça FT
                liste_field.append(convert_fields_by_bits(78,80,6,16,fic[trame+78:trame+80])) #field30 (décode en décimal)
                liste_field.append(check_FT(convert_fields(fic[trame+81:trame+82]),1)) #field32 (décode en décimal) puis regarde ça FT
                liste_field.append(convert_fields(fic[trame+82:trame+86])+((convert_fields(fic[trame+86:trame+88]))/2**16)) #field33/34 +35 (décode en décimal)
                TimePacket = PacketDate_affiche(convert_fields(fic[trame+82:trame+86])+((convert_fields(fic[trame+86:trame+88]))/2**16)) 
                

                objectfield = Field(liste_field) #crée un objet appelé objectfield pour stocker tous les fieds
                #on va récuperer les fields qui nous intéresses puis ensuite les mettre en binaire pour les concaténer
                field14 = str(bin(convert_fields_by_bits(70,72,3,4,fic[trame+70:trame+72])))[2:]
                field18 = str(bin(convert_fields_by_bits(70,72,11,16,fic[trame+70:trame+72])))[2:]
                field18 = field18.zfill(5) #fill avec des 0 pour obtenir la taille voulue
                field28 = str(bin(convert_fields_by_bits(77,78,2,8,fic[trame+77:trame+78])))[2:]
                field28 = field28.zfill(6) #fill avec des 0 pour obtenir la taille voulue
                field29 = str(bin(convert_fields_by_bits(78,80,0,6,fic[trame+78:trame+80])))[2:]
                field29 = field29.zfill(6) #fill avec des 0 pour obtenir la taille voulue
                field30 = str(bin(objectfield.lst_field[21]))[2:] #5 101 10
                field30 = field30.zfill(10) #fill avec des 0 pour obtenir la taille voulue

                FT_6 = field14 + field18 + field28 + field29 + field30 #concaténe

                FT_6 = int(FT_6,2) #transforme en entier pour pouvoir le mettre en hexadécimal
                FT_6 = hex(FT_6) #decode en hexadécimal
                FT_6 = check_FT(FT_6,6) #regarde ça FT
                objectfield.lst_field.append(FT_6) #l'ajoute à la liste de field
                

            elif field1 == '0806':
                date = date_affiche(convert_to_float_double(fic[trame+8:trame+16])) #frame date
                b3 = convert_to_dec(fic[trame+16:trame+20]) #bench3
                b5 = check_FT(convert_fields_by_bits(19,23,12,16,fic[trame+19:trame+23]),0) #bench5
                liste_field.append(field1) #field 1
                mac = check_FT(mac_address(convert_binary_hex(fic[trame+28:trame+34])),"MAC") #addresse MAC Dest
                mac2 = check_FT(mac_address(convert_binary_hex(fic[trame+34:trame+40])),"MAC") #addresse MAC Source
                liste_field.append(convert_fields(fic[trame+42:trame+44])) #field2
                liste_field.append(convert_fields(fic[trame+44:trame+46])) #field3
                liste_field.append(convert_fields(fic[trame+46:trame+47])) #field4
                liste_field.append(convert_fields(fic[trame+47:trame+48])) #field5
                liste_field.append(convert_fields(fic[trame+48:trame+50])) #field6
                mac_send = check_FT(mac_address(convert_binary_hex(fic[trame+50:trame+56])),"MAC") #addresse MAC Sender
                ip_send = check_FT(convert_to_ip(fic[trame+56:trame+60]),"IP") #addresse IP SENDER
                mac_target = check_FT(mac_address(convert_binary_hex(fic[trame+60:trame+66])),"MAC") #addresse MAC TARGET
                ip_target = check_FT(convert_to_ip(fic[trame+66:trame+70]),"IP") #addresse IP TARGET

                objectfield = Field(liste_field)
            
            try: #essaie ça si il n'y a pas d'erreur
                taille = fic[trame+24:trame+28]
                taille = convert_to_dec(taille)
                trame = trame + taille + 28
                curseur = connection.cursor()
                if field1 == '0800': #si le field est égal à 0800 alors
                    
                    mySql_insert_query = """INSERT INTO trame (date, pmid, bench3, bench5, framesize, macdst, macsrc, field1, field2, field3, field4, field5, field6, field7, ipsrc,
                    ipdst, field9, field10, field11, field14, field16, field17, field18, field20, field21, field23, field25, field26, field28, field29, field30, field32, field333435,
                    timepacket) 
                    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s) """
                    record = (date, FT_6, b3, b5, taille, mac, mac2, field1, convert_fields(fic[trame+42:trame+44]), convert_fields(fic[trame+44:trame+46]), convert_fields(fic[trame+46:trame+48]), convert_fields(fic[trame+48:trame+50]),
                          convert_fields(fic[trame+50:trame+51]), convert_fields(fic[trame+51:trame+52]), ip, ip2, convert_fields(fic[trame+62:trame+64]), convert_fields(fic[trame+64:trame+66]),
                          convert_fields(fic[trame+66:trame+68]), check_FT(convert_fields_by_bits(70,72,3,4,fic[trame+70:trame+72]),7), convert_fields_by_bits(70,72,5,8,fic[trame+70:trame+72]),
                          check_FT(convert_fields_by_bits(70,72,8,11,fic[trame+70:trame+72]),5), check_FT(convert_fields_by_bits(70,72,11,16,fic[trame+70:trame+72]),2),
                          convert_fields_by_bits(72,74,2,16,fic[trame+72:trame+74]), convert_fields(fic[trame+74:trame+76]), convert_fields_by_bits(76,77,4,5,fic[trame+76:trame+77]),
                          convert_fields_by_bits(76,77,6,7,fic[trame+76:trame+77]), convert_fields_by_bits(76,77,7,8,fic[trame+76:trame+77]), check_FT(convert_fields_by_bits(77,78,2,8,fic[trame+77:trame+78]),3),
                          check_FT(convert_fields_by_bits(78,80,0,6,fic[trame+78:trame+80]),4), convert_fields_by_bits(78,80,6,16,fic[trame+78:trame+80]), check_FT(convert_fields(fic[trame+81:trame+82]),1),
                          convert_fields(fic[trame+82:trame+86])+((convert_fields(fic[trame+86:trame+88]))/2**16), TimePacket,)
                    curseur.execute(mySql_insert_query, record)
                
                elif field1 == '0806':
                    
                    mySql_insert_query = """INSERT INTO trame (date, bench3, bench5, framesize, macdst, macsrc, field1, field2bis, field3bis, field4bis, field5bis, field6bis,
                    macsender, ipsender, mactarget, iptarget) 
                    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s) """
                    record = (date, b3, b5, taille, mac, mac2, field1, convert_fields(fic[trame+42:trame+44]), convert_fields(fic[trame+44:trame+46]), convert_fields(fic[trame+46:trame+47]),
                              convert_fields(fic[trame+47:trame+48]), convert_fields(fic[trame+48:trame+50]), mac_send, ip_send, mac_target, ip_target,)
                    curseur.execute(mySql_insert_query, record)
                
            except struct.error: #si il y a une erreur du type struct.error alors on marque fin du fichier et on passe state à false
                print("Fin du fichier")
                state = False

            cpt += 1 #incrémentation du compteur
        print(cpt)#affiche le nombre de ligne lue
        connection.commit()
        
            
            
        


