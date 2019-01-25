<?php

date_default_timezone_set('America/Lima');
/** 1=>ppd,2=>pam,3=>nna */

$modulos=array('1'=>('select \''.$anio.'\' as "Año",\''.$mes.'\' as "Periodo",\''.$fecha_inicial.'\' as "FEC_ENVIO",ca.CODIGO_ENTIDAD as "Código de la Entidad",ca.nombre_entidad as "Nombre de la Entidad", ca.codigo_linea as "Código de la Linea" ,ca.linea_intervencion as "Línea de Intervención" , ca.cod_serv as "Código del Servicio" , ca.nom_serv as "Nombre del Servicio", ca.ubigeo as "Ubigeo Según el INEI", (SELECT NOMDEPT FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Departamento Centro Atención", (SELECT NOMPROV FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Provincia Centro Atención", (SELECT NOMDIST FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Distrito Centro Atención",ca.centro_poblado as "C.Poblado centro atención" , ca.area_residencia as "Área de Residencia",ca.cod_ca as "Código Centro Atención",ca.nom_ca as "Nombre Centro Atención",ca.fecha_creacion as "Fecha de Registro",

cu.residente_id as Codigoresidente,cu.Nom_Usuario as "Nombre Usuario",cu.Ape_Paterno as "Apellido Paterno", cu.Ape_Materno as "Apellido Materno",

(SELECT nombre FROM pam_tipo_documento_identidad where id =cci.Tipo_Documento) "Tipo doc. identidad",cci.Numero_Documento as "Número del documento",

cu.Fecha_Nacimiento as "Fecha de Nacimiento",cu.Edad,cu.Sexo,(SELECT CODDIST FROM ubigeo WHERE CODDIST=cu.Distrito_Procedencia ) as "UBIGEO nacimiento",(SELECT NOMDEPT FROM ubigeo WHERE CODDIST=cu.Distrito_Procedencia) as "Departamento NAcimiento", (SELECT NOMPROV FROM ubigeo WHERE CODDIST=cu.Distrito_Procedencia ) as "Provincia NAcimiento", (SELECT NOMDIST FROM ubigeo WHERE CODDIST=cu.Distrito_Procedencia ) as "Distrito NAcimiento",

cda.Fecha_Ingreso as "Fecha de Ingreso",cda.Motivo_Ingreso as "Mótivo de Ingreso(EXP)",(SELECT nombre FROM pam_instituciones where id=cda.Institucion_derivado) as "Institución que lo Derivó",

csn.Discapacidad,csn.Discapacidad_Fisica as "Presenta Discap. Física",\'\' as "EST_USU",

ceg.Fecha_Egreso,ceg.Motivo_Egreso as "Motivo del Egreso",

cda.Fecha_Reingreso as "Fecha de Reingreso",\'\' as "GRupo Etario", \'\' as "DEtalle motivo Egreso",

ceg.Aus as "AUS",\'\' as "Partida de NAcimiento",ceg.DNI,\'\' as "Educación",ceg.Reinsercion as "Reinserción Familiar."


from CarIdentificacionUsuario cu 
,CarDatosAdmision cda  
,CarCondicionIngreso cci
,CarSaludNutricion csn
,CarEgresoGeneral ceg 

,centro_atencion ca 
,residente re
where cu.residente_id(+)=re.id and ca.id(+)= re.centro_id and cda.residente_id(+)=re.id and cci.residente_id(+)=re.id and csn.residente_id(+)=re.id and ceg.residente_id(+)=re.id and re.tipo_centro_id=1 
and ( 
        (
            (
                to_char(ceg.Fecha_Egreso,\'DD-MON-YY\') 
                BETWEEN UPPER(\''.$fecha_inicial.'\') AND UPPER("'.$fecha_final.'") 
                or to_char(cda.Fecha_Reingreso,\'DD-MON-YY\') 
                BETWEEN UPPER(\''.$fecha_inicial.'\') AND UPPER(\''.$fecha_final.'\') 
            )
            or (
                    to_char(cda.Fecha_Ingreso,\'DD-MON-YY\') <= UPPER(\''.$fecha_final.'\') and to_char(ceg.Fecha_Egreso,\'DD-MON-YY\') >= UPPER(\''.$fecha_final.'\')
                )
        )
    ) '.$where.''),

'2'=>('select \''.$anio.'\' as "Año",\''.$mes.'\' as "Periodo",\''.$fecha_inicial.'\' as "FEC_ENVIO",ca.CODIGO_ENTIDAD as "Código de la Entidad",ca.nombre_entidad as "Nombre de la Entidad", ca.codigo_linea as "Código de la Linea" ,ca.linea_intervencion as "Línea de Intervención" , ca.cod_serv as "Código del Servicio" , ca.nom_serv as "Nombre del Servicio", ca.ubigeo as "Ubigeo Según el INEI", (SELECT NOMDEPT FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Departamento Centro Atención", (SELECT NOMPROV FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Provincia Centro Atención", (SELECT NOMDIST FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Distrito Centro Atención",ca.centro_poblado as "C.Poblado centro atención" , ca.area_residencia as "Área de Residencia",ca.cod_ca as "Código Centro Atención",ca.nom_ca as "Nombre Centro Atención",ca.fecha_creacion as "Fecha de Registro",

pdi.residente_id as Codigoresidente,pdi.residente_nombre as "Nombre Usuario",pdi.residente_apellido_paterno as "Apellido Paterno", pdi.residente_apellido_materno as "Apellido Materno", pdci.tipo_documento_entidad as "Tipo doc. identidad",pdci.numero_documento_ingreso as "Número del documento",pdi.fecha_nacimiento as "Fecha de Nacimiento",pdi.edad,pdi.sexo,(SELECT CODDIST FROM ubigeo WHERE CODDIST=pdi.distrito_nacimiento_id ) as "UBIGEO nacimiento",(SELECT NOMDEPT FROM ubigeo WHERE CODDIST=pdi.distrito_nacimiento_id) as "Departamento Nacimiento", (SELECT NOMPROV FROM ubigeo WHERE CODDIST=pdi.distrito_nacimiento_id ) as "Provincia Nacimiento", (SELECT NOMDIST FROM ubigeo WHERE CODDIST=pdi.distrito_nacimiento_id ) as "Distrito Nacimiento",

pdau.fecha_ingreso_usuario as "Fecha de Ingreso",(SELECT nombre FROM pam_motivos_ingreso where id =pdau.motivo_ingreso_principal) as "Mótivo de Ingreso Principal",(SELECT nombre FROM pam_instituciones_deriva where id=pdau.institucion_deriva) as "Institución que lo Derivó",

pds.discapacidad,pds.discapacidad_fisica as "Presenta Discap. Física",\'\' as "EST_USU",

peu.Fecha_Egreso,peu.MotivoEgreso as "Motivo del Egreso",

pdau.movimiento_poblacional as "Movimiento Poblacional",\'\' as "GRupo Etario", \'\' as "DEtalle motivo Egreso",

\'\' as "AUS",\'\' as "Partida de NAcimiento",peu.documento_entidad as "DNI",(SELECT nombre FROM pam_nivel_educativo WHERE id = pdci.nivel_educativo and codigo=\'pam\') as "Nivel Educativo",peu.Reinsercion_Familiar as "Reinserción Familiar."

from     pam_datos_identificacion pdi 
,pam_datos_admision_usuario pdau 
,pam_datosCondicionIngreso pdci
,pam_datos_saludnutric pds
,pam_EgresoUsuario peu 

,centro_atencion ca 
,residente re
where pdi.residente_id(+)=re.id and ca.id(+)= re.centro_id and pdau.residente_id(+)=re.id and pdci.residente_id(+)=re.id and pds.residente_id(+)=re.id and peu.residente_id(+)=re.id and re.tipo_centro_id=2 
and ( (to_char(pdi.fecha_creacion(+),\'DD-MON-YY\') '.$fecha.') and (to_char(ca.fecha_creacion(+),\'DD-MON-YY\') '.$fecha.') and (to_char(pdau.fecha_creacion(+),\'DD-MON-YY\') '.$fecha.') and (to_char(pdci.fecha_creacion(+),\'DD-MON-YY\')) '.$where.''),

'3'=>('select \''.$anio.'\' as "Año",\''.$mes.'\' as "Periodo",\''.$fecha_inicial.'\' as "FEC_ENVIO",ca.CODIGO_ENTIDAD as "Código de la Entidad",ca.nombre_entidad as "Nombre de la Entidad", ca.codigo_linea as "Código de la Linea" ,ca.linea_intervencion as "Línea de Intervención" , ca.cod_serv as "Código del Servicio" , ca.nom_serv as "Nombre del Servicio", ca.ubigeo as "Ubigeo Según el INEI", (SELECT NOMDEPT FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Departamento Centro Atención", (SELECT NOMPROV FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Provincia Centro Atención", (SELECT NOMDIST FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Distrito Centro Atención",ca.centro_poblado as "C.Poblado centro atención" , ca.area_residencia as "Área de Residencia",ca.cod_ca as "Código Centro Atención",ca.nom_ca as "Nombre Centro Atención",ca.fecha_creacion as "Fecha de Registro",

nir.residente_id as Codigoresidente,nir.Nom_Usuario as "Nombre Usuario",nir.Ape_Paterno as "Apellido Paterno", nir.Ape_Materno as "Apellido Materno", 

nci.Tipo_Doc as "Tipo doc. identidad",nci.Numero_Doc as "Número del documento",

nir.Fecha_Nacimiento as "Fecha de Nacimiento",nir.Edad,nir.Sexo,(SELECT CODDIST FROM ubigeo WHERE CODDIST=nir.distrito_nacimiento_id ) as "UBIGEO nacimiento",(SELECT NOMDEPT FROM ubigeo WHERE CODDIST=nir.distrito_nacimiento_id) as "Departamento Nacimiento", (SELECT NOMPROV FROM ubigeo WHERE CODDIST=nir.distrito_nacimiento_id ) as "Provincia Nacimiento", (SELECT NOMDIST FROM ubigeo WHERE CODDIST=nir.distrito_nacimiento_id ) as "Distrito Nacimiento",

nar.Fecha_Ingreso as "Fecha de Ingreso",(SELECT nombre FROM nna_perfiles_ingreso where id =nar.Perfil_Ingreso_P) as "Mótivo de Ingreso Principal",(SELECT nombre FROM nna_instituciones where id=nar.Institucion_Derivacion) as "Institución que lo Derivó",

nds.Discapacidad,nds.Discapacidad_Fisica as "Presenta Discap. Física",\'\' as "EST_USU",

neu.Fecha_Egreso,neu.MotivoEgreso as "Motivo del Egreso",

nar.Fecha_Registro as "Fecha de Reingreso",\'\' as "GRupo Etario", 

neu.Detalle_Motivo as "DEtalle motivo Egreso",neu.Salud_AUS as "Asegura. Univ.l de Salud-AUS",neu.Partida_Naci as "Partida de Nacimiento"

\'\' as "AUS",\'\' as "Partida de NAcimiento",neu.documento_entidad as "DNI",(SELECT nombre FROM pam_nivel_educativo WHERE id = pdci.nivel_educativo and codigo=\'pam\') as "Nivel Educativo",neu.Reinsercion_Familiar as "Reinserción Familiar.",neu.DNI as "DNI", neu.Educacion, neu.Reinsecion_Familiar as "Reinseción Familiar"

from  NNAInscripcionResidente nir 
,NNAAdmisionResidente nar 
,NNACondicionIResidente nci
,NNADatosSaludResi nds  
,NNAEgresoUsuario neu

,centro_atencion ca 
,residente re
where pdi.residente_id(+)=re.id and ca.id(+)= re.centro_id and pdau.residente_id(+)=re.id and pdci.residente_id(+)=re.id and pds.residente_id(+)=re.id and peu.residente_id(+)=re.id and re.tipo_centro_id=2 
and ( (to_char(pdi.fecha_creacion(+),\'DD-MON-YY\') '.$fecha.') and (to_char(ca.fecha_creacion(+),\'DD-MON-YY\') '.$fecha.') and (to_char(pdau.fecha_creacion(+),\'DD-MON-YY\') '.$fecha.') and (to_char(pdci.fecha_creacion(+),\'DD-MON-YY\')) '.$where.''));

?>