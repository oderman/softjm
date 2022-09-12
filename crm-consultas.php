<?php
$conexion = mysql_connect("localhost","odermancom_jm_crm",")S{q9V7hBJv;");
//$conexion = mysql_connect("localhost","root","1234");
//AGREGAR/MODIFICAR COLUMNAS

#Fecha última actualización: 26 de Mayo de 2020
$inicio = "ALTER TABLE";
$tabla = "configuracion"; 
$columnas = "
ADD COLUMN `conf_cliente_imprimir_certificado` INTEGER UNSIGNED COMMENT 'Permiso para que el cliente pueda imprimir su certificado.' AFTER `conf_vencimiento_puntos`
";

/*SIN EJECUTAR
ALTER TABLE `odermancom_jm_crm`.`combos` ADD COLUMN `combo_descuento_dealer` VARCHAR(45) AFTER `combo_descuento_maximo`;

ALTER TABLE `odermancom_jm_crm`.`configuracion` ADD COLUMN `conf_cliente_imprimir_certificado` INTEGER UNSIGNED COMMENT 'Permiso para que el cliente pueda imprimir su certificado.' AFTER `conf_vencimiento_puntos`;

ALTER TABLE `odermancom_jm_crm`.`configuracion` ADD COLUMN `conf_vencimiento_puntos` DATE AFTER `conf_coreo_puntos`;

ALTER TABLE `odermancom_jm_crm`.`configuracion` ADD COLUMN `conf_coreo_puntos` VARCHAR(45) COMMENT 'Para los clientes' AFTER `conf_comision_vendedores`;


ALTER TABLE `odermancom_jm_crm`.`cotizacion_productos` ADD COLUMN `czpp_costo` VARCHAR(45) COMMENT 'Valor congelado' AFTER `czpp_utilidad`,
 ADD COLUMN `czpp_utilidad_porcentaje` VARCHAR(45) COMMENT 'Valor congelado' AFTER `czpp_costo`;

ALTER TABLE `odermancom_jm_crm`.`productos_historial_precios` ADD COLUMN `php_causa` INTEGER UNSIGNED NOT NULL DEFAULT 1 COMMENT 'Costo - Utilidad' AFTER `php_usuario`;

ALTER TABLE `odermancom_jm_crm`.`usuarios` ADD COLUMN `usr_meta_ventas` VARCHAR(45) AFTER `usr_sucursal`;

CREATE TABLE `odermancom_jm_crm`.`metricas` (
  `met_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `met_meta_venta_mes` VARCHAR(45),
  `met_dias_habiles` VARCHAR(45),
  `met_bonificacion_mes` VARCHAR(45) COMMENT 'Mejor asesor',
  `met_punto_equilibrio` VARCHAR(45),
  PRIMARY KEY (`met_id`)
)
ENGINE = InnoDB;



ALTER TABLE `odermancom_jm_crm`.`usuarios` ADD COLUMN `usr_sucursal` INTEGER UNSIGNED AFTER `usr_intentos_fallidos`;


CREATE TABLE `odermancom_jm_crm`.`clientes_orion` (
  `clio_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `clio_empresa` VARCHAR(255),
  `clio_email` VARCHAR(100),
  `clio_telefono` VARCHAR(45),
  `clio_contacto_principal` VARCHAR(255),
  `clio_fecha_inicio` DATE,
  `clio_fecha_fin` DATE,
  `clio_observaciones` LONGTEXT,
  PRIMARY KEY (`clio_id`)
)
ENGINE = InnoDB;

ALTER TABLE `odermancom_jm_crm`.`clientes_orion` ADD COLUMN `clio_aviso_previo` VARCHAR(45) DEFAULT 30 AFTER `clio_observaciones`;

ALTER TABLE `odermancom_jm_crm`.`configuracion` ADD COLUMN `conf_comision_vendedores` VARCHAR(45) AFTER `conf_porcentaje_clientes`;

ALTER TABLE `odermancom_jm_crm`.`configuracion` ADD COLUMN `conf_porcentaje_clientes` VARCHAR(45) AFTER `conf_encabezado2_pedido`;

*/


//En esta se hacen los cambios inicialmente
#mysql_query($inicio." odermancom_jm_crm.".$tabla." ".$columnas,$conexion);
#if(mysql_errno()!=0){echo mysql_error()." - JM<br>"; $e=1;}

mysql_query($inicio." odermancom_orioncrm_exacta.".$tabla." ".$columnas,$conexion);
if(mysql_errno()!=0){echo mysql_error()." - Exacta<br>"; $e=1;}

mysql_query($inicio." odermancom_orioncrm_ingestore.".$tabla." ".$columnas,$conexion);
if(mysql_errno()!=0){echo mysql_error()." - Ingestore<br>"; $e=1;}

mysql_query($inicio." odermancom_orioncrm_orion.".$tabla." ".$columnas,$conexion);
if(mysql_errno()!=0){echo mysql_error()." - ORION COMPANY<br>"; $e=1;}

mysql_query($inicio." odermancom_orioncrm_asalliancesas.".$tabla." ".$columnas,$conexion);
if(mysql_errno()!=0){echo mysql_error()." - AS ALLIANCE<br>"; $e=1;}

mysql_query($inicio." orioncrmcom_oscar.".$tabla." ".$columnas,$conexion);
if(mysql_errno()!=0){echo mysql_error()." - OSCAR<br>"; $e=1;}




mysql_query($inicio." odermancom_orioncrm_demo.".$tabla." ".$columnas,$conexion);
if(mysql_errno()!=0){echo mysql_error()." - DEMO ORION<br>";}

if($e=='0'){
	echo "<b>La consulta fue ejecutada correctamente para todas las empresas.</b> - Tabla: ".$tabla.", Columnas: ".$columnas;
}