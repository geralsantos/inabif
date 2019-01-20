<?php

$campos = array('NNAInscripcionResidente'=>
'residente_apellido_paterno as "Apellido paterno usuario",
residente_apellido_materno as "Apellido materno usuario",
residente_nombre as "Nombre usuario",
(SELECT nombre FROM paises WHERE id=NNAInscripcionResidente.pais_procedente_id) as "Pai­s de procedencia usuario",
(SELECT NOMDEPT FROM ubigeo WHERE coddist=NNAInscripcionResidente.departamento_nacimiento_id) as "Departamento de nac del usuario",
(SELECT NOMPROV FROM ubigeo WHERE coddist=NNAInscripcionResidente.provincia_nacimiento_id) as "Provincia de nac del usuario" ,
(SELECT NOMPROV FROM ubigeo WHERE coddist=NNAInscripcionResidente.distrito_nacimiento_id) as "Distrito de nac del usuario",
(CASE sexo WHEN \'h\' THEN 2 WHEN \'m\' THEN 1 END) as "Sexo",
fecha_nacimiento as "Fecha de nacimiento" ,
(SELECT nombre from pam_lengua_materna WHERE id = NNAInscripcionResidente.lengua_materna) as "Lengua materna"',

'NNAAdmisionResidente'=>
'Fecha_Ingreso as "Fecha de Ingreso del usuario",
(SELECT nombre FROM nna_instituciones WHERE id=NNAAdmisionResidente.Institucion_Derivacion) as "Entidad que lo deriva",
(SELECT nombre FROM nna_motivos_ingreso WHERE id=NNAAdmisionResidente.Motivo_Ingreso)  as "Motivo ingreso PRINCIPAL (expediente)",
(SELECT nombre FROM nna_motivos_ingreso WHERE id=NNAAdmisionResidente.Motivo_Ingreso)  as "Motivo ingreso PRINCIPAL (real)",
Numero_Doc as "Número documento de ingreso",
Perfil_Ingreso_P as "Perfil de ingreso"',

'NNACondicionIResidente'=>
'Numero_Doc as "DNI al ingreso",
Tipo_Doc as "Tipo de documento de identidad",
"" as "Número del documento de ingreso",
"" as "Pensión",
Lee_Escribe as "¿Sabe leer y escribir?",
(SELECT nombre FROM pam_nivel_educativo WHERE id=NNACondicionIResidente.Nivel_Educativo) as "Nivel Educativo",
(SELECT nombre FROM pam_tipo_seguro_salud WHERE id=NNACondicionIResidente.Tipo_Seguro) as "Tipo de Seguro de Salud",
(SELECT nombre FROM pam_clasif_socioeconomico WHERE id=NNACondicionIResidente.SISFOH) as "Clasificación Socioeconómica (SISFOH)",
"" as "Cobertura médica",
"" as "Tipo de aseguramiento"',

'NNADatosSaludResi'=>
'Discapacidad as "Discapacidad",
Discapacidad_Fisica as "Presenta discapacidad física",
Discapaciada_Intelectual as "Presenta discapacidad intelectual",
Discapacidad_Sensorial as "Presenta discapacidad sensorial",
Discapacidad_Mental as "Presenta discapacidad mental",
Carnet_CANADIS as "Tiene carnet del CONADIS",
"" as "Grado de dependencia de la PAM",
"" as "Motivo de dificultad con el desplazamiento",
"" as "Patología crónica 1",
"" as "Tipo de patología",
"" as "Especifique"',


'NNADatosSaludResi'=>
'Nivel_Hemoglobina as "Nivel de Hemoglobina",
Peso as "Peso (Kg.)",
Talla as "Talla (m)",
Estado_Nutricional1 as "Estado Nutricional (IMC)"',

'NNAFamiliaresResidente'=>
'Familiares as "Cuenta con familiares",
Parentesco as "Tipo de parentesco"',

'NNADatosSaludResi'=>
'Transtornos_Comportamiento as "Transtorno de comportamiento y/o disociales",
Tipo_Transtorno as "Tipo de transtorno"',

'NNAEgresoUsuario'=>
'Fecha_Egreso as "Fecha de egreso",
MotivoEgreso as "Motivo de egreso",
Detalle_Motivo as "Detalle del motivo del egreso",
Salud_AUS as "Aseguramiento universal de Salud-AUS",
Partida_Naci as "Partida de Nacimiento",
DNI as "DNI",
Educacion as "Educación",
Reinsecion_Familiar as "Reinserción Familiar"');

$campos = array('CarIdentificacionUsuario'=>
'Ape_Paterno as "Apellido paterno",Ape_Materno as "Apellido materno",
Nom_Usuario as "Nombre Usuario",
(SELECT nombre FROM paises WHERE id=CarIdentificacionUsuario.Pais_Procencia) as "Pai­s de procedencia usuario",
(SELECT NOMDEPT FROM ubigeo WHERE coddist=CarIdentificacionUsuario.Departamento_Procedencia) as "Departamento de nac del usuario",
(SELECT NOMPROV FROM ubigeo WHERE coddist=CarIdentificacionUsuario.Provincia_Procedencia) as "Provincia de nac del usuario" ,
(SELECT NOMPROV FROM ubigeo WHERE coddist=CarIdentificacionUsuario.Distrito_Procedencia) as "Distrito de nac del usuario",
(CASE Sexo WHEN \'h\' THEN 2 WHEN \'m\' THEN 1 END) as "Sexo",
Fecha_Nacimiento as "Fecha de Nacimiento",
(SELECT nombre from pam_lengua_materna WHERE id = CarIdentificacionUsuario.Lengua_Materna) as "Lengua Materna"',

'CarDatosAdmision'=>
'Fecha_Ingreso as "Fecha de ingreso del usuario",
(SELECT nombre FROM pam_instituciones WHERE id=CarDatosAdmision.Institucion_derivado) as "Entidad que lo deriva",
Motivo_Ingreso  as "Motivo ingreso PRINCIPAL (expediente)",
""  as "Motivo ingreso PRINCIPAL (real)",
Numero_Documento as "Número documento de ingreso"',

'CarCondicionIngreso'=>
'DNI as "DNI al ingreso",
(SELECT nombre FROM pam_tipo_documento_identidad WHERE id=CarCondicionIngreso.Tipo_Documento) as "Tipo de documento de identidad",
 Numero_Documento as "Número de documento de ingreso",
 Posee_Pension as "Pensión",
 (SELECT nombre FROM pam_tipo_pension WHERE id=CarCondicionIngreso.Tipo_Pension) as "Tipo de pensión",
 Lee_Escribe as "Sabe Leer y Escribir",
 (SELECT nombre FROM pam_nivel_educativo where id=CarCondicionIngreso.Nivel_Educativo) as "Nivel Educativo",
 (SELECT nombre FROM pam_clasif_socioeconomico where id = CarCondicionIngreso.Clasficacion_Socioeconomica) as "Clasificación Socioeconómica (SISFOH)",
"" as "Cobertura médica",
 (SELECT nombre FROM pam_tipo_seguro_salud WHERE id=CarCondicionIngreso.Tipo_Seguro) as "Tipo de aseguramiento"',

 'CarSaludNutricion'=>'Discapacidad as "Discapacidad",
 Discapacidad_Fisica as "Presenta discapacidad física",
 Discapacidad_Intelectual as "Presenta discapacidad intelectual",
  Discapacidad_Sensorial as "Presenta discapacidad sensorial",
  Discapacidad_mental as "Presenta discapacidad mental",
  Carnet_CONADIS as "Tiene carnet de CONADIS",
  "" as "Grado de dependencia de la PAM",
  Motivo_Movilidad as "Motivo de dificultad Desplazamiento",
  Patologia1 as "Patología Crónica 1",
  (SELECT nombre FROM pam_tipo_patologia WHERE id =CarSaludNutricion.Tipo_Patologia1) as "Tipo de Patología",
  Especifique1  as "Especifique"',

  'CarSaludNutricion'=>'Nivel_Hemoglobina as "Nivel de Hemoglobina",
   Peso as "Peso (Kg.)",
   Talla as "Talla (m)",
   Estado_Nutricional as "Estado Nutricional(IMC)"',

   'CarCondicionIngreso'=>
   'Familiares as "Cuenta con familiares",
    Parentesco as "Tipo de parentesco"',

    'CarCondicionIngreso'=>
    '"" as "Transtorno de comportamiento y/o disociales",
    ""Tipo_Transtorno as"" "Tipo de transtorno"',

    'NNAEgresoUsuario'=>
'Fecha_Egreso as "Fecha de egreso",
Motivo_Egreso as "Motivo de egreso",
Traslado as "Traslado",
Reinsercion as "Reinserción Familiar",
Grado_Parentesco as "Grado de Parentesco",
Retiro_Voluntario as "Retiro Voluntario",
Fallecimiento as "Fallecimiento",
Constancia_Naci as "Constancia de Nacimiento",
Carnet_CONADIS as "Carnet CONADIS",
DNI as "DNI",
Restitucion as "Restitución Familiar",
Restitucion_Derechos as "Cumplimiento de restitución de derechos"');


     $campos = array('pam_datos_identificacion'=>
     'residente_apellido_paterno as "Apellido paterno usuario",
     residente_apellido_materno as "Apellido materno usuario",
     residente_nombre as "Nombre Usuario",
     (SELECT nombre FROM paises WHERE id=pam_datos_identificacion.pais_procedente_id) as "Pai­s de procedencia usuario",
     (SELECT NOMDEPT FROM ubigeo WHERE coddist=pam_datos_identificacion.distrito_nacimiento_id) as "Departamento de nac del usuario",
     (SELECT NOMPROV FROM ubigeo WHERE coddist=pam_datos_identificacion.distrito_nacimiento_id) as "Provincia de nac del usuario",
     (SELECT NOMPROV FROM ubigeo WHERE coddist=pam_datos_identificacion.distrito_nacimiento_id) as "Distrito de nac del usuario",
     (CASE sexo WHEN \'h\' THEN 2 WHEN \'m\' THEN 1 END) as "Sexo",
     fecha_nacimiento as "Fecha de Nacimiento",
     (SELECT nombre from pam_lengua_materna WHERE id = pam_datos_identificacion.lengua_materna) as "Lengua Materna"',


     'pam_datos_admision_usuario'=>
     'fecha_ingreso_usuario as "Fecha de Ingreso del usuario",
     (SELECT nombre FROM pam_instituciones_deriva WHERE id=pam_datos_admision_usuario.institucion_deriva) as "Entidad que lo deriva",
     (SELECT nombre FROM pam_motivos_ingreso WHERE id = pam_datos_admision_usuario.motivo_ingreso_principal) as "Motivo ingreso PRINCIPAL (expediente)",
     (SELECT nombre FROM pam_motivos_ingreso WHERE id = pam_datos_admision_usuario.motivo_ingreso_secundario)as "Motivo ingreso PRINCIPAL (real)",
     numero_documento_ingreo_car as "Número documento de ingreso",
     perfil_ingreso as "Perfil de Ingreso"',

     'pam_datosCondicionIngreso'=>
     'documento_entidad as "DNI al ingreso",
     tipo_documento_entidad as "Tipo de documento de identidad",
     numero_documento_ingreso as "Número del documento de ingreso",
     "" as "Pensión",
     tipo_pension as "Tipo de pensión",
     leer_escribir as "Sabe Leer y Escribir",
     (SELECT nombre FROM pam_nivel_educativo where id=pam_datosCondicionIngreso.nivel_educativo) as "Nivel Educativo",
    "" as "Cobertura médica",
     (SELECT nombre FROM pam_clasif_socioeconomico where id = pam_datosCondicionIngreso.SISFOH) as "Clasificación Socioeconómica (SISFOH)",
     (SELECT nombre FROM pam_tipo_seguro_salud WHERE id=pam_datosCondicionIngreso.aseguramiento_salud) as "Tipo de aseguramiento"',


'pam_datos_saludnutric'=>
'discapacidad as "Discapacidad",
discapacidad_fisica as "Presenta discapacidad física",
discapacidad_intelectual as "Presenta discapacidad intelectual",
discapacidad_sensorial as "Presenta discapacidad sensorial",
presenta_discapacidad_mental as  "Presenta discapacidad mental",
carnet_conadis as "Tiene carnet del CONADIS",
grado_dependencia_pam as "Grado dependencia PAM",
motivo_dif_desplazamiento as "Motivo de dificultad con el desplazamiento",
enfermedad_ingreso_1 as "Patología crónica 1",
(SELECT nombre FROM pam_tipo_patologia WHERE id =pam_datos_saludnutric.tipo_patologia) as "Tipo de patología",
"" as "Especifique"',

'pam_datos_saludnutric'=>
'nivel_hemoglobina as "Nivel de Hemoglobina",
peso as "Peso (Kg.)",
talla as "Talla (m)",
estado_nutricional as "Estado Nutricional(IMC)"',

'pam_datosCondicionIngreso'=>
'familiar_ubicados as "Cuenta con familiares",
tipo_parentesco as "Tipo de parentesco"',

'pam_salud_mental'=>
'trastorno_disociales as "Transtorno de comportamiento y/o disociales",
tipo_trastorno as "Tipo de transtorno"',


'pam_EgresoUsuario'=>
'Fecha_Egreso as "Fecha de egreso",
MotivoEgreso as "Motivo de egreso",
Retiro_Voluntario as "Retiro Voluntario",
Reinsercion_Familiar as "Reinserción familiar",

Traslado_Entidad_Salud as "Traslado a una entidad de salud",
Traslado_Otra_Entidad as "Traslado a otra Entidad",
Fallecimiento as "Fallecimiento",
RestitucionAseguramientoSaludo as "Cumplimiento de restitución de derechos salud",
Restitucion_Derechos_DNI as "Cumplimiento de restitución de derechos dni",
RestitucionReinsercionFamiliar as "Cumplimiento de restitución de derechos Reinserción Familiar"');


// ESTRUCTURA DE LA TABLA
<h2>DATOS GENERALES DE INGRESO</h2>

<table style="width:100%">
	<tr><th colspan="2" style="background-color:yellow">DATOS DE CONDICIÓN DE INGRESO</th>
    </tr>
  <tr>
    <th>Fecha de ingreso:</th>
    <td>19-03-2018</td>
  </tr>
  <tr>
    <th>Motivo de ingreso</th>
    <td>Abandono</td>
  </tr>
</table>
<br>

<table style="width:100%">
	<tr><th colspan="2" style="background-color:yellow">DATOS DE ADMISIÓN DEL USUARIO</th>
    </tr>
  <tr>
    <th>Fecha de ingreso:</th>
    <td>19-03-2018</td>
  </tr>
  <tr>
    <th>Motivo de ingreso</th>
    <td>Abandono</td>
  </tr>
</table>
<br>
<h2>DATOS GENERALES DE EGRESO</h2>
<br>
<table style="width:100%">
<tr><th colspan="2" style="background-color:yellow">DATOS DE EGRESO DEL USUARIO</th>
    </tr>
  <tr>
    <th>Fecha de Egreso:</th>
    <td>19-03-2018</td>
  </tr>
  <tr>
    <th>Motivo de egreso</th>
    <td>Muerte natural</td>
  </tr>
</table>





// NNA

