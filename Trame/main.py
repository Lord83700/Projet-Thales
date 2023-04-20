#!/usr/bin/python3


from fonctions import *
from field import *


if __name__ == '__main__':

    with open("./ethernet.result_data", 'rb') as bin:

        trame = 0
        
        fic = bin.read()

        state = True

        cpt = 0

        while cpt < 1:
            
            field1 = convert_field_hex(fic[trame+40:trame+42])
            liste_field = []

            if field1 == '0800':
                date = date_affiche(convert_to_float_double(fic[trame+8:trame+16]))
                mac = mac_address(convert_binary_hex(fic[trame+28:trame+34]))
                mac2 = mac_address(convert_binary_hex(fic[trame+34:trame+40]))
                ip = convert_to_ip(fic[trame+54:trame+58])
                ip2 = convert_to_ip(fic[trame+58:trame+62])
                b3 = convert_fields(fic[trame+16:trame+20])
                b5 = convert_fields_by_bits(19,23,12,16,fic[trame+19:trame+23]) #marche pas là

                liste_field.append(field1) #f1
                liste_field.append(convert_fields(fic[trame+42:trame+44])) #field2
                liste_field.append(convert_fields(fic[trame+44:trame+46])) #field3
                liste_field.append(convert_fields(fic[trame+46:trame+48])) #field4
                liste_field.append(convert_fields(fic[trame+48:trame+50])) #field5
                liste_field.append(convert_fields(fic[trame+50:trame+51])) #field6
                liste_field.append(convert_fields(fic[trame+51:trame+52])) #field7
                liste_field.append(convert_fields(fic[trame+62:trame+64])) #field9
                liste_field.append(convert_fields(fic[trame+64:trame+66])) #field10
                liste_field.append(convert_fields(fic[trame+66:trame+68])) #field11
                #liste_field.append(convert_fields_by_bits(70,72,0,3,fic[trame+70:trame+72])) #field13 ######
                liste_field.append(convert_fields_by_bits(70,72,3,4,fic[trame+70:trame+72])) #field14 ok
                #liste_field.append(convert_fields_by_bits(70,72,4,5,fic[trame+70:trame+72])) #field15 #######
                liste_field.append(convert_fields_by_bits(70,72,5,8,fic[trame+70:trame+72])) #field16 ok
                liste_field.append(convert_fields_by_bits(70,72,8,11,fic[trame+70:trame+72])) #field17 ok
                liste_field.append(convert_fields_by_bits(70,72,11,16,fic[trame+70:trame+72])) #field18 ok
                liste_field.append(convert_fields_by_bits(72,74,2,16,fic[trame+72:trame+74])) #field20 ok
                liste_field.append(convert_fields(fic[trame+74:trame+76]))#field21 ok
                liste_field.append(convert_fields_by_bits(76,77,4,5,fic[trame+76:trame+77])) #field23 # ok
                liste_field.append(convert_fields_by_bits(76,77,6,7,fic[trame+76:trame+77])) #field25 ok
                liste_field.append(convert_fields_by_bits(76,77,7,8,fic[trame+76:trame+77])) #field26 # ok 77o
                liste_field.append(convert_fields_by_bits(77,78,2,8,fic[trame+77:trame+78])) #field28 ###### 78o ok
                liste_field.append(convert_fields_by_bits(78,80,0,6,fic[trame+78:trame+80])) #field29 # ok
                liste_field.append(convert_fields_by_bits(78,80,6,16,fic[trame+78:trame+80])) #field30 # ok
                liste_field.append(convert_fields(fic[trame+81:trame+82]))
                

                objectfield = Field(liste_field)
            
                print("La date =",date,"Les adresses mac =", mac, mac2,"Les adresses IP =",ip,ip2,"Bench 3 =",b3, "Bench 5 =",b5)
                objectfield.affiche()

            elif field1 == '0806':
                date = date_affiche(convert_to_float_double(fic[trame+8:trame+16]))
                b3 = convert_to_dec(fic[trame+16:trame+20])
                #b5
                liste_field.append(field1)
                mac = mac_address(convert_binary_hex(fic[trame+28:trame+34]))
                mac2 = mac_address(convert_binary_hex(fic[trame+34:trame+40]))
                liste_field.append(convert_fields(fic[trame+42:trame+44]))
                liste_field.append(convert_fields(fic[trame+44:trame+46]))
                liste_field.append(convert_fields(fic[trame+46:trame+47]))
                liste_field.append(convert_fields(fic[trame+47:trame+48]))
                liste_field.append(convert_fields(fic[trame+48:trame+50])) #field6
                mac_send = mac_address(convert_binary_hex(fic[trame+50:trame+56]))
                ip_send = convert_to_ip(fic[trame+56:trame+60])
                mac_target = mac_address(convert_binary_hex(fic[trame+60:trame+66]))
                ip_target = convert_to_ip(fic[trame+66:trame+70])

                objectfield = Field(liste_field)

                print("La date =",date,"Les adresses mac =", mac, mac2,"Les adresses IP =",ip,ip2,"Bench3 =",b3,mac_send,mac_target,ip_send,ip_target)
                objectfield.affiche()


            
            try:
                taille = fic[trame+24:trame+28]
                taille = convert_to_dec(taille)
                trame = trame + taille + 28
            except struct.error:
                print("Fin du fichier")
                state = False

            cpt += 1
        print(cpt)
        
            
            
        


