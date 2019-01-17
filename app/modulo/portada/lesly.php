<?php

$campos = array('NNAInscripcionResidente'=>
'residente_apellido_paterno as "Apellido paterno",
residente_apellido_materno as "Apellido materno",
residente_nombre as "Nombre Usuario",
(SELECT nombre FROM paises WHERE id=NNAInscripcionResidente.pais_procedente_id) as "Pai­s de procedencia",
(SELECT NOMDEPT FROM ubigeo WHERE coddist=NNAInscripcionResidente.departamento_nacimiento_id) as "Departamento de nac",
(SELECT NOMPROV FROM ubigeo WHERE coddist=NNAInscripcionResidente.provincia_nacimiento_id) as "Provincia de nac del" ,
(SELECT NOMPROV FROM ubigeo WHERE coddist=NNAInscripcionResidente.distrito_nacimiento_id) as "Distrito de nac",
(CASE sexo WHEN \'h\' THEN 2 WHEN \'m\' THEN 1 END) as Sexo,fecha_nacimiento,
(SELECT nombre from pam_lengua_materna WHERE id = NNAInscripcionResidente.lengua_materna) as "Lengua Materna"',


'NNAAdmisionResidente'=>
'Fecha_Ingreso as "Fecha de Ingreso",
(SELECT nombre FROM nna_instituciones WHERE id=NNAAdmisionResidente.Institucion_Derivacion) as "Entidad que lo deriva",
(SELECT nombre FROM nna_motivos_ingreso WHERE id=NNAAdmisionResidente.Motivo_Ingreso)  as "Motivo ingreso PRINCIPAL",
Numero_Doc as "Número documento de Ingreso",
Perfil_Ingreso_P as "Perfil de Ingreso"',



'NNACondicionIResidente'=>
'Numero_Doc as "DNI",
"Tipo_Doc as Tipo de documento de identidad",
Lee_Escribe as "¿Sabe leer y escribir?",
(SELECT nombre FROM pam_nivel_educativo WHERE id=NNACondicionIResidente.Nivel_Educativo) as "Nivel Educativo",
(SELECT nombre FROM pam_tipo_seguro_salud WHERE id=NNACondicionIResidente.Tipo_Seguro) as "Tipo de Seguro de Salud",
(SELECT nombre FROM pam_clasif_socioeconomico WHERE id=NNACondicionIResidente.SISFOH) as "Clasificación Socioeconómica (SISFOH)"',

'NNADatosSaludResi'=>
'Discapacidad as "Discapacidad",
Discapacidad_Fisica as "Presenta discap. física",
Discapaciada_Intelectual as "Presenta discap. intelectual",
Discapacidad_Sensorial as "Presenta discap. sensorial",
Discapacidad_Mental as "Presenta discap. mental",
Carnet_CANADIS as "Carnet CONADIS",
Transtornos_Neuro as "Trastorno Neurológico"',


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




);