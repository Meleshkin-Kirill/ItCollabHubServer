import socket
import detect
import threading, time

sock = None

def res():
    sock = socket.socket()
    sock.bind(('', ТУТ БЫЛ ПОРТ ДЛЯ ПОДКЛЮЧЕНИЯ НО МЫ ЕГО СЪЕЛИ))
    sock.listen(1)
    print("Server start")
    while True:
        conn, addr = sock.accept()

        print ('connected:'+ str(addr))
    
        while True:
            data = conn.recv(1024)
            if not data:
                break
            conn.send(detect.classify_input(data.decode('utf-8')).encode('utf-8'))

    conn.close()

while True:
    t = threading.Timer(3600.0, res())
    t.start()  
    sock.shutdown()
    sock.close()