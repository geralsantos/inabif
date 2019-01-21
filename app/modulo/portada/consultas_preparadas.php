<?php

$ppd_matriz_general = 'select cu.residente_id as Codigoresidente,ca.CODIGO_ENTIDAD as "Código de la Entidad",ca.nombre_entidad as "Nombre de la Entidad", ca.codigo_linea as "Código de la Linea" ,ca.linea_intervencion as "Línea de Intervención" , ca.cod_serv as "Código del Servicio" , ca.nom_serv as "Nombre del Servicio", ca.ubigeo as "Ubigeo Según el INEI", (SELECT NOMDEPT FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Departamento Centro Atención", (SELECT NOMPROV FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Provincia Centro Atención", (SELECT NOMDIST FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Distrito Centro Atención", ca.area_residencia as "Área de Residencia",ca.cod_ca as "Código Centro Atención",ca.nom_ca as "Nombre Centro Atención",ca.fecha_creacion as "Fecha de Registro",cu.Ape_Paterno as "Apellido Paterno", cu.Ape_Materno as "Apellido Materno",cu.Nom_Usuario as "Nombre Usuario",(SELECT NOMDEPT FROM ubigeo WHERE CODDIST=cu.Distrito_Procedencia) as "Departamento Usuario", (SELECT NOMPROV FROM ubigeo WHERE CODDIST=cu.Distrito_Procedencia ) as "Provincia Usuario", (SELECT NOMDIST FROM ubigeo WHERE CODDIST=cu.Distrito_Procedencia ) as "Distrito Usuario", cu.Sexo, cu.Fecha_Nacimiento as "Fecha de Nacimiento", cda.Fecha_Ingreso as "Fecha de Ingreso del Usuario",(SELECT nombre FROM pam_instituciones where id=cda.Institucion_derivado) as "Institución que lo Derivó",cda.Numero_Documento as "Número documento ingreso CAR",cda.Motivo_Ingreso as "Mótivo de Ingreso(EXP)",cda.Mov_Poblacional as "Movimiento Poblacional", cci.DNI as "Documento Identifdad ingreso", (SELECT nombre FROM pam_tipo_documento_identidad where id =cci.Tipo_Documento) "Tipo doc. identidad INGRESO", cci.Numero_Documento as "Número del documento",cci.Posee_Pension as "Posee algún tipo de Pensión",(SELECT nombre FROM pam_tipo_pension where id=cci.Tipo_Pension) as "Tipo de pensión que percibe",cci.Lee_Escribe as "Usuario sabe Leer y Escribir",(SELECT nombre FROM pam_nivel_educativo WHERE id = cci.Nivel_Educativo and codigo=\'ppd\') as "Nivel Educativo",(SELECT nombre FROM pam_institucion_educativa WHERE id=cci.Institucion_Educativa) as "Inst. Educativa Procedencia",(SELECT nombre FROM pam_clasif_socioeconomico WHERE id=cci.Clasficacion_Socioeconomica ) as "Clasificación Socioeconómica",(SELECT nombre FROM pam_tipo_seguro_salud where id=cci.Tipo_Seguro) as "Tipo de seguro de salud", cci.Familiares as "Familiares Ubicados",(SELECT nombre FROM pam_tipo_parentesco where id=cci.Parentesco) as "Tipo de parentesco",csn.Discapacidad,csn.Discapacidad_Fisica as "Presenta Discap. Física",csn.Discapacidad_Intelectual as "Presenta Discap. Intelectual",csn.Discapacidad_Sensorial  as "Presenta Discap. Sensorial",csn.Discapacidad_mental as "Presenta Discap. Mental",csn.Certificacdo_Dx as "El Dx es certificado", csn.Carnet_CONADIS "Tiene carnet del CONADIS", csn.movilidad, csn.Motivo_Movilidad as "Motivo de dif. desplazamiento",(SELECT nombre FROM dificultades_cuerpo where id=csn.Dificultad_Movilidad) as "Dificultad de brazos y cuerpo", csn.Patologia1 as "Patología crónica 1",(SELECT nombre FROM pam_tipo_patologia where id=csn.Tipo_Patologia1) as "Tipo de patología",csn.Especifique1 as "Especifique", csn.Patologia2 as "Patología crónica 2",(SELECT nombre FROM pam_tipo_patologia where id=csn.Tipo_Patologia2 ) as "Tipo de patología",csn.Especifique2 as "Especifique",csn.Nivel_Hemoglobina as "Nivel de Hemoglobina",csn.Peso as "Peso(Kg.)", csn.Talla as "Talla(m)", csn.Estado_Nutricional as "Estado nutricional (imc)",csm.Transtorno_Neurologico, (SELECT nombre FROM cie_10 where id=csm.Des_Transtorno) as "Especif.Trastorno Neurológico",(SELECT nombre FROM pam_tipo_transtorno_conducta where id=csm.Tipo_Transtorno) as "Tipo de trastorno de coducta",csm.Dificultad_habla as "dificultades para el habla", csm.Metodo_comunicarse as "Método para comunicarse",csm.Comprension as "dificultades para comprender",csm.Tipo_Dificultad as "Tipo de dificultad presenta",(SELECT nombre FROM pam_actividades_diaria where id=csm.Actividades_Diarias) as "actividades de la vida diaria",csm.Especificar as "Especificar(forma)",ct.Num_TMotriz as "Nº terap.reeducación motriz",ct.Num_TPsicomotricidad as "Nº terapia Psicomotricidad",ct.Num_TFisioterapia  as "Nº Fisioterapia respiratoria",ct.Num_TDeportes  as "Nº terapia Deportes Adaptados",ct.Num_TComunicacion  as "Nº terapia comunicación",ct.Num_TOrofacial  as "Nº reeducación orofacial",ct.Num_TLenguaje as "Nº Desarrollo de leng. alter.",ct.Num_TLenguajeA as "Tipo de lenguaje alternativo",ct.Num_TABVD as "Nº activ.Básicas Vida Diaria", ct.Num_TInstrumentalesB as "Nº activ. Instr. Básicas",ct.Num_TInstrumentalesC as "Nº activ. Instr. Complejas", ct.Num_TSensoriales as "Nº activ. Interven. sensorial",ct.Num_TReceptivas as "Nº activ. Senso receptivas",ct.Num_TOrteticos as "Nº activ. bachas y ortéticos",ct.Num_TSoillaR as "Nº activ. sillas de ruedas",cac.Num_Biohuerto as "Nº veces taller de Biohuerto", cac.Num_Manualidades as "Nº veces taller Manualidades",cac.Num_Panaderia as "Nº veces taller Reposteria",cac.Num_Paseos as "Nº veces paseos o caminatas",cac.Num_Culturales as "Nº veces visitas culturales",cac.Num_Civicas as "Activ. cívicas protocolares",cac.Num_Futbol as "Nº veces deporte Fútbol",cac.Num_Natacion as "Nº veces deporte natación", cac.Num_otrosDe as "Nº veces Otros Deportes",cac.Num_ManejoDinero as "Nº ense. Manejo de Dinero",cac.Num_decisiones as "toma de decisiones con apoyo",cap.Num_HBasicas as "Desarrollo hablidades básicas", cap.Num_HConceptuales as "Veces hablidades conceptuales", cap.Num_HSociales as "Nºhablidades sociales",cap.Num_HPracticas as "N° habilidades prácticas",cap.Num_HModificacion as "Nº Modificación de conducta",cec.Tipo_Institucion as "Tipo de IIEE a la que asiste",cec.Insertado_labora as "Residente insert.laboralmente",cec.Des_labora as "Desc. participación laboral", cec.Participa_Actividades as "NNA hablidades conceptuales",cec.Fecha_InicionA as "Fecha inicio personal/social",cec.Fecha_FinA as "Fecha final personal/social",cec.Culmino_Actividades as "NNA conluyó personal/social",cec.Logro_Actividades as "NNA logró personales/sociales",cts.Visitas as "visitas de Familiares", cts.Num_Visitas as "Nº Visitas al Mes", cts.Reinsercion_Familiar as "Reinserción Familiar",cts.Familia_RedesS as "Familia accede soporte social", cts.Des_Persona_Visita as "Des. Persona Visita",cts.DNI as "Residente cuenta con DNI",cts.AUS as "Residente cuenta con AUS",cts.CONADIS as "Cuenta con carnet CONADIS",cas.Num_MedicinaG as "N° Atenciones Med.General", cas.Salida_Hospitales as "Salidas a hospitales al mes",cas.NumSalidasHospital as "N° salidas a hospitales", cas.Num_Cardiovascular as "N° Atenciones CArdiovascular",cas.Num_Nefrologia as "N° Atenciones nefrología",cas.Num_Oncologia as "N° Atenciones Oncología",cas.Num_Neurocirugia as "N° Atenciones Neurocirugía",cas.Num_Dermatologia as "N° Atenciones dermatología",cas.Num_Endocrinologia as "N° Atenciones Endocrinología",cas.Num_Gastroenterologia as "N° Atenc. gastroenterología",cas.Num_Gineco_Obsterica as "N° Atenc.gineco-obstetricia",cas.Num_Infec_contagiosa as "N° Atenc.Infecto-contagiosas",cas.Num_Hematologia as "N° Atenciones hematología",cas.Num_Medicina_fisica as "N° Atenc.Medi.Física Rehabi.",cas.Num_Neumologia as "N° Atenciones neumología",cas.Num_Nutricion as "N° Atenciones Nutrición",cas.Num_Neurologia as "N° Atenciones Neurología",cas.Num_Oftalmologia as "N° Atenciones oftalmología", cas.Num_Otorrinolarinlogia as "N°Atenc.OTORRINOLARINGOLOGIA",cas.Num_Pedriatria as "N° Atenciones Pediatría",cas.Num_Psiquiatria as "N° Atenciones psiquiatría",cas.Num_Quirurgica as "N° Atenciones quirurgica",cas.Num_Traumologia as "N° Atenciones traumatología", cas.Num_Urologia as "N° Atenciones urología",cas.Num_Odontologia as "N° Atenciones odontología",cas.Num_Otro as "N° Atenc. Otros Servicios",cas.Tratamiento_Psicofarmaco as "Tratamiento Psicofármaco",cas.Hopitalizado_Periodo as "hospitalizado en el periodo",cas.Numero_Hospitalizaciones as "Número de hospitalizaciones",cas.MotivoHospitalizacion as "Motivo de la hospitalización",cep.Plan_Psicologico as "Posee Plan Psicológico", cep.Meta_PII as "Meta trazada en el PII", cep.Informe_Tecnico as "Informe técnico evolutivo",cep.Des_Informe as "Des Informe evolutivo",cep.Cumple_Plan as "Cump.plan de intervención",cee.Plan_Educacion as "interv. Educación  indiv.",cee.Meta_PII as "des meta trazada en el PII",cee.Informe_Tecnico as "Posee inf. técnico evolutivo",cee.Des_Informe as "Des del informe evolutivo", cee.Cumple_Plan as "Cump. plan de intervención", cee.Asistencia_Escolar as "Asis. escolar cont. periodo",cee.Desempeno as "Desempeño academ. favorable",ces.Plan_Medico as "intervención médico  indiv.", ces.Meta_PII as "des meta trazada en el PII",ces.Informe_Tecnico as "Posee inf. técnico evolutivo", ces.Des_Informe as "Des del informe evolutivo",ces.Cumple_Plan as "Cump. plan de intervención", ces.Enfermedades_Cronicas as "Enfermedades crónicas degen.",ces.Especificar as "Especificar la enfermedad",ctf.Plan_Medico as "intervención médico indiv.",ctf.Meta_PII as "Des meta trazada en el PII", ctf.Informe_Tecnico as "Posee inf. técnico evolutivo",ctf.Des_Informe as "Des del informe evolutivo", ctf.Cumple_Plan as "Cump. plan de intervención", ctf.Desarrollo_Lenguaje as "Desarrollo de capac.lenguaje",ctf.Mejora_Fonema as "Mejora emisión de fonemas",ctf.Mejora_Comprensivo as "Mejora lenguaje comprensivo",ctf.Elabora_Oraciones as "Construc./elabora. oraciones", cen.Plan_Nutricional as "posee plan nutricional",cen.Meta_PII as "Des meta trazada en el PII",cen.Informe_Tecnico as "Posee inf. técnico evolutivo",cen.Des_Informe as "Des del informe evolutivo", cen.Cumple_Plan as "Cump. plan de intervención",cen.Estado_Nutricional as "Estado Nutricional(IMC)", cen.Peso as "Peso(Kg.)", cen.Talla as "Talla(m)", cen.Hemoglobina as "Hemoglobina (gr./dl)",cets.Plan_Social as "Plan Intervención Social",cets.Meta_PII as "Des meta trazada en el PII",cets.Informe_Tecnico as "Posee inf. técnico evolutivo",cets.Des_Informe as "Des del informe evolutivo", cets.Cumple_Plan as "Cump. plan de intervención", cets.Ubicacion_Familia as "Ubicación de la familia", cets.Participacion_Familia as "Participación activa familia",cets.Reinsercion as "Posibilidad de Reinserción", cets.Colocacion_Laboral as "Posib. Colocación Laboral",ceg.Fecha_Egreso,ceg.Motivo_Egreso as "Motivo del Egreso",ceg.Retiro_Voluntario as "Retiro Voluntario",ceg.Reinsercion as "Reinserción Familiar",ceg.Grado_Parentesco as "Grado de Parentesco", ceg.Traslado as "Traslado", ceg.Fallecimiento, ceg.Restitucion_Derechos as "Cump.restitu.derechos egreso", ceg.Aus as "AUS",ceg.Constancia_Naci as "Constancia de NAcimiento", ceg.Carnet_CONADIS as "Carnet del CONADIS",ceg.DNI,ceg.Restitucion as "Restitución Familiar"  from 
        CarIdentificacionUsuario cu 
        ,CarDatosAdmision cda 
        ,CarCondicionIngreso cci
        ,CarSaludNutricion csn
        ,CarSaludMental csm 
        ,CarTerapia ct  
        ,CarActividades cac 
        ,CarAtencionPsicologica cap 
        ,CarEducacionCapacidades cec 
        ,CarTrabajoSocial cts 
        ,CarAtencionSalud cas 
        ,CarEgresoPsicologico cep 
        ,CarEgresoEducacion cee 
        ,CarEgresoSalud ces 
        ,CarTerapiaFisica ctf 
        ,CarEgresoNutricion cen 
        ,CarEgresoTrabajoSocial cets 
        ,CarEgresoGeneral ceg 
        ,centro_atencion ca 
        ,residente re
        where cu.residente_id(+)=re.id and ca.id(+)= re.centro_id and cda.residente_id(+)=re.id and cci.residente_id(+)=re.id and csn.residente_id(+)=re.id and csm.residente_id(+)=re.id and ct.residente_id(+)=re.id and cac.residente_id(+)=re.id and cap.residente_id(+)=re.id and cec.residente_id(+)=re.id and cts.residente_id(+)=re.id and cas.residente_id(+)=re.id and cep.residente_id(+)=re.id and cee.residente_id(+)=re.id and ces.residente_id(+)=re.id and ctf.residente_id(+)=re.id and cen.residente_id(+)=re.id and cets.residente_id(+)=re.id and ceg.residente_id(+)=re.id and re.tipo_centro_id=1 and ( (to_char(cu.fecha_creacion,\'DD-MON-YY\') '.$fecha.') or (to_char(ca.fecha_creacion,\'DD-MON-YY\') '.$fecha.') or (to_char(cda.fecha_creacion,\'DD-MON-YY\') '.$fecha.') or (to_char(cci.fecha_creacion,\'DD-MON-YY\')  '.$fecha.') or (to_char(csn.fecha_creacion,\'DD-MON-YY\')  '.$fecha.') or (to_char(csm.fecha_creacion,\'DD-MON-YY\')  '.$fecha.') or (to_char(ct.fecha_creacion,\'DD-MON-YY\')  '.$fecha.') or (to_char(cac.fecha_creacion,\'DD-MON-YY\')  '.$fecha.') or (to_char(cap.fecha_creacion,\'DD-MON-YY\')  '.$fecha.') or (to_char(cec.fecha_creacion,\'DD-MON-YY\')  '.$fecha.') or (to_char(cts.fecha_creacion,\'DD-MON-YY\')  '.$fecha.') or (to_char(cas.fecha_creacion,\'DD-MON-YY\')  '.$fecha.') or (to_char(cep.fecha_creacion,\'DD-MON-YY\')  '.$fecha.') or (to_char(cee.fecha_creacion,\'DD-MON-YY\')  '.$fecha.') or (to_char(ces.fecha_creacion,\'DD-MON-YY\')  '.$fecha.') or (to_char(ctf.fecha_creacion,\'DD-MON-YY\')  '.$fecha.') or (to_char(cen.fecha_creacion,\'DD-MON-YY\')  '.$fecha.') or (to_char(cets.fecha_creacion,\'DD-MON-YY\')  '.$fecha.') or (to_char(ceg.fecha_creacion,\'DD-MON-YY\')  '.$fecha.') )';

?>