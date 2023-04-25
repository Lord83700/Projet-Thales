#!/usr/bin/python3


from fonctions import *
from field import *


if __name__ == '__main__':

    with open("./ethernet.result_data", 'rb') as binary:

        trame = 0
        
        fic = binary.read()

        state = True

        cpt = 0

        while state == True:
            
            field1 = convert_field_hex(fic[trame+40:trame+42])
            liste_field = []

            if field1 == '0800':
                date = date_affiche(convert_to_float_double(fic[trame+8:trame+16]))
                mac = check_FT(mac_address(convert_binary_hex(fic[trame+28:trame+34])),"MAC")
                mac2 = check_FT(mac_address(convert_binary_hex(fic[trame+34:trame+40])),"MAC")
                ip = check_FT(convert_to_ip(fic[trame+54:trame+58]),"IP")
                ip2 = check_FT(convert_to_ip(fic[trame+58:trame+62]),"IP")
                b3 = convert_fields(fic[trame+16:trame+20])
                b5 = check_FT(convert_fields_by_bits(19,23,12,16,fic[trame+19:trame+23]),0) #bench5

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
                liste_field.append(check_FT(convert_fields_by_bits(70,72,3,4,fic[trame+70:trame+72]),7)) #field14 ok 11
                #liste_field.append(convert_fields_by_bits(70,72,4,5,fic[trame+70:trame+72])) #field15 #######
                liste_field.append(convert_fields_by_bits(70,72,5,8,fic[trame+70:trame+72])) #field16 ok 12
                liste_field.append(check_FT(convert_fields_by_bits(70,72,8,11,fic[trame+70:trame+72]),5)) #field17 ok 13
                liste_field.append(check_FT(convert_fields_by_bits(70,72,11,16,fic[trame+70:trame+72]),2)) #field18 ok 14
                liste_field.append(convert_fields_by_bits(72,74,2,16,fic[trame+72:trame+74])) #field20 ok 15
                liste_field.append(convert_fields(fic[trame+74:trame+76]))#field21 ok 16
                liste_field.append(convert_fields_by_bits(76,77,4,5,fic[trame+76:trame+77])) #field23 # ok 17
                liste_field.append(convert_fields_by_bits(76,77,6,7,fic[trame+76:trame+77])) #field25 ok 18
                liste_field.append(convert_fields_by_bits(76,77,7,8,fic[trame+76:trame+77])) #field26 # ok 77o 19
                liste_field.append(check_FT(convert_fields_by_bits(77,78,2,8,fic[trame+77:trame+78]),3)) #field28 ###### 78o ok 20
                liste_field.append(check_FT(convert_fields_by_bits(78,80,0,6,fic[trame+78:trame+80]),4)) #field29 # ok 21
                liste_field.append(convert_fields_by_bits(78,80,6,16,fic[trame+78:trame+80])) #field30 # ok 22
                liste_field.append(check_FT(convert_fields(fic[trame+81:trame+82]),1)) #field32 ok 23
                liste_field.append(convert_fields(fic[trame+82:trame+86])+((convert_fields(fic[trame+86:trame+88]))/2**16)) #field33/34 +35 ok
                TimePacket = PacketDate_affiche(convert_fields(fic[trame+82:trame+86])+((convert_fields(fic[trame+86:trame+88]))/2**16)) 
                

                objectfield = Field(liste_field)
                field14 = str(bin(convert_fields_by_bits(70,72,3,4,fic[trame+70:trame+72])))[2:] #0 0
                field18 = str(bin(convert_fields_by_bits(70,72,11,16,fic[trame+70:trame+72])))[2:] #0 00000 5
                field18 = field18.zfill(5)
                field28 = str(bin(convert_fields_by_bits(77,78,2,8,fic[trame+77:trame+78])))[2:] #3 000011 6
                field28 = field28.zfill(6)
                field29 = str(bin(convert_fields_by_bits(78,80,0,6,fic[trame+78:trame+80])))[2:] #15 001111 6
                field29 = field29.zfill(6)
                field30 = str(bin(objectfield.lst_field[21]))[2:] #5 101 10
                field30 = field30.zfill(10)

                FT_6 = field14 + field18 + field28 + field29 + field30

                FT_6 = int(FT_6,2)
                FT_6 = hex(FT_6)
                FT_6 = check_FT(FT_6,6)
                objectfield.lst_field.append(FT_6)
                
                print("La date =",date,"Les adresses mac =", mac, mac2,"Les adresses IP =",ip,ip2,"Bench 3 =",b3, "Bench 5 =",b5,"Time Packet =", TimePacket)
                objectfield.affiche()

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

                print("La date =",date,"Les adresses mac =", mac, mac2,"Les adresses IP =",ip,ip2,"Bench3 =",b3,"Bench 5 =",b5,mac_send,mac_target,ip_send,ip_target)
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
        
            
            
        


