USE contadorcitodb;

INSERT INTO tbl_Comprobantes_Venta 
(empresa_id, tipo_comprobante_id, numero, fecha, monto, cliente, archivo_pdf, archivo_json, usuario_id)
VALUES
(1, 1, 'VENT-00001', '2024-11-01', 250.50, 'Cliente A', 'venta_00001.pdf', 'venta_00001.json', 1),
(1, 2, 'VENT-00002', '2024-11-02', 325.75, 'Cliente B', 'venta_00002.pdf', 'venta_00002.json', 1),
(2, 1, 'VENT-00003', '2024-11-03', 400.00, 'Cliente C', 'venta_00003.pdf', 'venta_00003.json', 1),
(3, 2, 'VENT-00004', '2024-11-04', 150.25, 'Cliente D', 'venta_00004.pdf', 'venta_00004.json', 1),
(4, 1, 'VENT-00005', '2024-11-05', 500.50, 'Cliente E', 'venta_00005.pdf', 'venta_00005.json', 1),
(1, 2, 'VENT-00006', '2024-11-06', 225.75, 'Cliente F', 'venta_00006.pdf', 'venta_00006.json', 1),
(2, 1, 'VENT-00007', '2024-11-07', 300.00, 'Cliente G', 'venta_00007.pdf', 'venta_00007.json', 1),
(3, 2, 'VENT-00008', '2024-11-08', 175.25, 'Cliente H', 'venta_00008.pdf', 'venta_00008.json', 1),
(4, 1, 'VENT-00009', '2024-11-09', 550.00, 'Cliente I', 'venta_00009.pdf', 'venta_00009.json', 1),
(1, 2, 'VENT-00010', '2024-11-10', 125.75, 'Cliente J', 'venta_00010.pdf', 'venta_00010.json', 1),
(2, 1, 'VENT-00011', '2024-11-11', 375.50, 'Cliente K', 'venta_00011.pdf', 'venta_00011.json', 1),
(3, 2, 'VENT-00012', '2024-11-12', 200.00, 'Cliente L', 'venta_00012.pdf', 'venta_00012.json', 1),
(4, 1, 'VENT-00013', '2024-11-13', 425.75, 'Cliente M', 'venta_00013.pdf', 'venta_00013.json', 1),
(1, 2, 'VENT-00014', '2024-11-14', 150.25, 'Cliente N', 'venta_00014.pdf', 'venta_00014.json', 1),
(2, 1, 'VENT-00015', '2024-11-15', 300.00, 'Cliente O', 'venta_00015.pdf', 'venta_00015.json', 1),
(3, 2, 'VENT-00016', '2024-11-16', 450.50, 'Cliente P', 'venta_00016.pdf', 'venta_00016.json', 1),
(4, 1, 'VENT-00017', '2024-11-17', 275.75, 'Cliente Q', 'venta_00017.pdf', 'venta_00017.json', 1),
(1, 2, 'VENT-00018', '2024-11-18', 125.00, 'Cliente R', 'venta_00018.pdf', 'venta_00018.json', 1),
(2, 1, 'VENT-00019', '2024-11-19', 325.50, 'Cliente S', 'venta_00019.pdf', 'venta_00019.json', 1),
(3, 2, 'VENT-00020', '2024-11-20', 500.00, 'Cliente T', 'venta_00020.pdf', 'venta_00020.json', 1);

INSERT INTO tbl_Comprobantes_Compra 
(empresa_id, tipo_comprobante_id, numero, fecha, monto, proveedor, archivo_pdf, archivo_json, usuario_id)
VALUES
(1, 1, 'FAC-00001', '2024-11-01', 150.75, 'Proveedor A', 'factura_00001.pdf', 'factura_00001.json', 1),
(1, 2, 'FAC-00002', '2024-11-02', 200.00, 'Proveedor B', 'factura_00002.pdf', 'factura_00002.json', 1),
(2, 1, 'FAC-00003', '2024-11-03', 300.50, 'Proveedor C', 'factura_00003.pdf', 'factura_00003.json', 1),
(3, 2, 'FAC-00004', '2024-11-04', 450.00, 'Proveedor D', 'factura_00004.pdf', 'factura_00004.json', 1),
(4, 1, 'FAC-00005', '2024-11-05', 500.25, 'Proveedor E', 'factura_00005.pdf', 'factura_00005.json', 1),
(1, 2, 'FAC-00006', '2024-11-06', 175.50, 'Proveedor F', 'factura_00006.pdf', 'factura_00006.json', 1),
(2, 1, 'FAC-00007', '2024-11-07', 220.00, 'Proveedor G', 'factura_00007.pdf', 'factura_00007.json', 1),
(3, 2, 'FAC-00008', '2024-11-08', 330.75, 'Proveedor H', 'factura_00008.pdf', 'factura_00008.json', 1),
(4, 1, 'FAC-00009', '2024-11-09', 410.00, 'Proveedor I', 'factura_00009.pdf', 'factura_00009.json', 1),
(1, 2, 'FAC-00010', '2024-11-10', 125.25, 'Proveedor J', 'factura_00010.pdf', 'factura_00010.json', 1),
(2, 1, 'FAC-00011', '2024-11-11', 275.75, 'Proveedor K', 'factura_00011.pdf', 'factura_00011.json', 1),
(3, 2, 'FAC-00012', '2024-11-12', 350.00, 'Proveedor L', 'factura_00012.pdf', 'factura_00012.json', 1),
(4, 1, 'FAC-00013', '2024-11-13', 480.25, 'Proveedor M', 'factura_00013.pdf', 'factura_00013.json', 1),
(1, 2, 'FAC-00014', '2024-11-14', 260.00, 'Proveedor N', 'factura_00014.pdf', 'factura_00014.json', 1),
(2, 1, 'FAC-00015', '2024-11-15', 390.75, 'Proveedor O', 'factura_00015.pdf', 'factura_00015.json', 1),
(3, 2, 'FAC-00016', '2024-11-16', 410.00, 'Proveedor P', 'factura_00016.pdf', 'factura_00016.json', 1),
(4, 1, 'FAC-00017', '2024-11-17', 520.25, 'Proveedor Q', 'factura_00017.pdf', 'factura_00017.json', 1),
(1, 2, 'FAC-00018', '2024-11-18', 210.50, 'Proveedor R', 'factura_00018.pdf', 'factura_00018.json', 1),
(2, 1, 'FAC-00019', '2024-11-19', 310.00, 'Proveedor S', 'factura_00019.pdf', 'factura_00019.json', 1),
(3, 2, 'FAC-00020', '2024-11-20', 420.75, 'Proveedor T', 'factura_00020.pdf', 'factura_00020.json', 1);
