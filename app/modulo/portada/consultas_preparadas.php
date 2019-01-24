<?php
date_default_timezone_set('America/Lima');
/** 1=>ppd,2=>pam,3=>nna */
$modulos = array('1'=>('select cu.residente_id as Codigoresidente,\''.($periodo_anio."-".date("F",strtotime($periodo_mes))).'\' as "Periodo",ca.CODIGO_ENTIDAD as "Código de la Entidad",ca.nombre_entidad as "Nombre de la Entidad", ca.codigo_linea as "Código de la Linea" ,ca.linea_intervencion as "Línea de Intervención" , ca.cod_serv as "Código del Servicio" , ca.nom_serv as "Nombre del Servicio", ca.ubigeo as "Ubigeo Según el INEI", (SELECT NOMDEPT FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Departamento Centro Atención", (SELECT NOMPROV FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Provincia Centro Atención", (SELECT NOMDIST FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Distrito Centro Atención",ca.centro_poblado as "C.Poblado centro atención" , ca.area_residencia as "Área de Residencia",ca.cod_ca as "Código Centro Atención",ca.nom_ca as "Nombre Centro Atención",ca.fecha_creacion as "Fecha de Registro",cu.Ape_Paterno as "Apellido Paterno", cu.Ape_Materno as "Apellido Materno",cu.Nom_Usuario as "Nombre Usuario",(SELECT nombre FROM paises WHERE id=cu.Pais_Procencia) as "País de Procedencia",(SELECT NOMDEPT FROM ubigeo WHERE CODDIST=cu.Distrito_Procedencia) as "Departamento Usuario", (SELECT NOMPROV FROM ubigeo WHERE CODDIST=cu.Distrito_Procedencia ) as "Provincia Usuario", (SELECT NOMDIST FROM ubigeo WHERE CODDIST=cu.Distrito_Procedencia ) as "Distrito Usuario", cu.Sexo, cu.Fecha_Nacimiento as "Fecha de Nacimiento", cda.Fecha_Ingreso as "Fecha de Ingreso del Usuario",(SELECT nombre FROM pam_instituciones where id=cda.Institucion_derivado) as "Institución que lo Derivó",cda.Numero_Documento as "Número documento ingreso CAR",cda.Motivo_Ingreso as "Mótivo de Ingreso(EXP)",cda.Mov_Poblacional as "Movimiento Poblacional",cda.Fecha_Ingreso as "Fecha de Ingreso", cci.DNI as "Documento Identifdad ingreso", (SELECT nombre FROM pam_tipo_documento_identidad where id =cci.Tipo_Documento) "Tipo doc. identidad INGRESO", cci.Numero_Documento as "Número del documento",cci.Posee_Pension as "Posee algún tipo de Pensión",(SELECT nombre FROM pam_tipo_pension where id=cci.Tipo_Pension) as "Tipo de pensión que percibe",cci.Lee_Escribe as "Usuario sabe Leer y Escribir",(SELECT nombre FROM pam_nivel_educativo WHERE id = cci.Nivel_Educativo and codigo=\'ppd\') as "Nivel Educativo",(SELECT nombre FROM pam_institucion_educativa WHERE id=cci.Institucion_Educativa) as "Inst. Educativa Procedencia",(SELECT nombre FROM pam_clasif_socioeconomico WHERE id=cci.Clasficacion_Socioeconomica ) as "Clasificación Socioeconómica",(SELECT nombre FROM pam_tipo_seguro_salud where id=cci.Tipo_Seguro) as "Tipo de seguro de salud", cci.Familiares as "Familiares Ubicados",(SELECT nombre FROM pam_tipo_parentesco where id=cci.Parentesco) as "Tipo de parentesco",cci.Problematica_Familiar as "Problemática Familiar",csn.Discapacidad,csn.Discapacidad_Fisica as "Presenta Discap. Física",csn.Discapacidad_Intelectual as "Presenta Discap. Intelectual",csn.Discapacidad_Sensorial  as "Presenta Discap. Sensorial",csn.Discapacidad_mental as "Presenta Discap. Mental",csn.Certificacdo_Dx as "El Dx es certificado", csn.Carnet_CONADIS "Tiene carnet del CONADIS", csn.movilidad, csn.Motivo_Movilidad as "Motivo de dif. desplazamiento",(SELECT nombre FROM dificultades_cuerpo where id=csn.Dificultad_Movilidad) as "Dificultad de brazos y cuerpo", csn.Patologia1 as "Patología crónica 1",(SELECT nombre FROM pam_tipo_patologia where id=csn.Tipo_Patologia1) as "Tipo de patología",csn.Especifique1 as "Especifique", csn.Patologia2 as "Patología crónica 2",(SELECT nombre FROM pam_tipo_patologia where id=csn.Tipo_Patologia2 ) as "Tipo de patología 2",csn.Especifique2 as "Especifique 2",csn.Nivel_Hemoglobina as "Nivel de Hemoglobina",csn.Peso as "Peso(Kg.)", csn.Talla as "Talla(m)", csn.Estado_Nutricional as "Estado nutricional (imc)",csm.Transtorno_Neurologico, (SELECT nombre FROM cie_10 where id=csm.Des_Transtorno) as "Especif.Trastorno Neurológico",(SELECT nombre FROM pam_tipo_transtorno_conducta where id=csm.Tipo_Transtorno) as "Tipo de trastorno de coducta",csm.Dificultad_habla as "dificultades para el habla", csm.Metodo_comunicarse as "Método para comunicarse",csm.Comprension as "dificultades para comprender",csm.Tipo_Dificultad as "Tipo de dificultad presenta",(SELECT nombre FROM pam_actividades_diaria where id=csm.Actividades_Diarias) as "actividades de la vida diaria",csm.Especificar as "Especificar(forma)",ct.Num_TMotriz as "Nº terap.reeducación motriz",ct.Num_TPsicomotricidad as "Nº terapia Psicomotricidad",ct.Num_TFisioterapia  as "Nº Fisioterapia respiratoria",ct.Num_TDeportes  as "Nº terapia Deportes Adaptados",ct.Num_TComunicacion  as "Nº terapia comunicación",ct.Num_TOrofacial  as "Nº reeducación orofacial",ct.Num_TLenguaje as "N°Participa terapia Lenguaje",ct.Num_TLenguajeA as "Nº Desarrollo de leng. alter.",ct.Tipo_LenguajeA as "Tipo de lenguaje alternativo",ct.Num_TABVD as "Nº activ.Básicas Vida Diaria", ct.Num_TInstrumentalesB as "Nº activ. Instr. Básicas",ct.Num_TInstrumentalesC as "Nº activ. Instr. Complejas", ct.Num_TSensoriales as "Nº activ. Interven. sensorial",ct.Num_TReceptivas as "Nº activ. Senso receptivas",ct.Num_TOrteticos as "Nº activ. bachas y ortéticos",ct.Num_TSoillaR as "Nº activ. sillas de ruedas",cac.Num_Biohuerto as "Nº veces taller de Biohuerto", cac.Num_Manualidades as "Nº veces taller Manualidades",cac.Num_Panaderia as "Nº veces taller Reposteria",cac.Num_Paseos as "Nº veces paseos o caminatas",cac.Num_Culturales as "Nº veces visitas culturales",cac.Num_Civicas as "Activ. cívicas protocolares",cac.Num_Futbol as "Nº veces deporte Fútbol",cac.Num_Natacion as "Nº veces deporte natación", cac.Num_otrosDe as "Nº veces Otros Deportes",cac.Num_ManejoDinero as "Nº ense. Manejo de Dinero",cac.Num_decisiones as "toma de decisiones con apoyo",cap.Num_HBasicas as "Desarrollo hablidades básicas", cap.Num_HConceptuales as "Veces hablidades conceptuales", cap.Num_HSociales as "Nºhablidades sociales",cap.Num_HPracticas as "N° habilidades prácticas",cap.Num_HModificacion as "Nº Modificación de conducta",cec.Tipo_Institucion as "Tipo de IIEE a la que asiste",cec.Insertado_labora as "Residente insert.laboralmente",cec.Des_labora as "Desc. participación laboral", cec.Participa_Actividades as "NNA hablidades conceptuales",cec.Fecha_InicionA as "Fecha inicio personal/social",cec.Fecha_FinA as "Fecha final personal/social",cec.Culmino_Actividades as "NNA conluyó personal/social",cec.Logro_Actividades as "NNA logró personales/sociales",cts.Visitas as "visitas de Familiares", cts.Num_Visitas as "Nº Visitas al Mes", cts.Reinsercion_Familiar as "Reinserción Familiar",cts.Familia_RedesS as "Familia accede soporte social", cts.Des_Persona_Visita as "Des. Persona Visita",cts.DNI as "Residente cuenta con DNI",cts.AUS as "Residente cuenta con AUS",cts.CONADIS as "Cuenta con carnet CONADIS",cas.Num_MedicinaG as "N° Atenciones Med.General", cas.Salida_Hospitales as "Salidas a hospitales al mes",cas.NumSalidasHospital as "N° salidas a hospitales", cas.Num_Cardiovascular as "N° Atenciones CArdiovascular",cas.Num_Nefrologia as "N° Atenciones nefrología",cas.Num_Oncologia as "N° Atenciones Oncología",cas.Num_Neurocirugia as "N° Atenciones Neurocirugía",cas.Num_Dermatologia as "N° Atenciones dermatología",cas.Num_Endocrinologia as "N° Atenciones Endocrinología",cas.Num_Gastroenterologia as "N° Atenc. gastroenterología",cas.Num_Gineco_Obsterica as "N° Atenc.gineco-obstetricia",cas.Num_Hematologia as "N° Atenciones hematología",
cas.Num_Infec_contagiosa as "N° Atenc.Infecto-contagiosas",cas.Num_Inmunologia as "N° Atenc.Inmunología",cas.Num_Medicina_fisica as "N° Atenc.Medi.Física Rehabi.",cas.Num_Neumologia as "N° Atenciones neumología",cas.Num_Nutricion as "N° Atenciones Nutrición",cas.Num_Neurologia as "N° Atenciones Neurología",cas.Num_Oftalmologia as "N° Atenciones oftalmología", cas.Num_Otorrinolarinlogia as "N°Atenc.OTORRINOLARINGOLOGIA",cas.Num_Pedriatria as "N° Atenciones Pediatría",cas.Num_Psiquiatria as "N° Atenciones psiquiatría",cas.Num_Quirurgica as "N° Atenciones quirurgica",cas.Num_Traumologia as "N° Atenciones traumatología", cas.Num_Urologia as "N° Atenciones urología",cas.Num_Odontologia as "N° Atenciones odontología",cas.Num_Otro as "N° Atenc. Otros Servicios",cas.Tratamiento_Psicofarmaco as "Tratamiento Psicofármaco",cas.Hopitalizado_Periodo as "hospitalizado en el periodo",cas.Numero_Hospitalizaciones as "Número de hospitalizaciones",cas.MotivoHospitalizacion as "Motivo de la hospitalización",cep.Plan_Psicologico as "Posee Plan Psicológico", cep.Meta_PII as "Meta trazada en el PII", cep.Informe_Tecnico as "Informe técnico evolutivo",cep.Des_Informe as "Des Informe evolutivo",cep.Cumple_Plan as "Cump.plan de intervención",cee.Plan_Educacion as "interv. Educación  indiv.",cee.Meta_PII as "des meta trazada en el PII",cee.Informe_Tecnico as "Posee inf. técnico evolutivo",cee.Des_Informe as "Des del informe evolutivo", cee.Cumple_Plan as "Cump. plan de intervención", cee.Asistencia_Escolar as "Asis. escolar cont. periodo",cee.Desempeno as "Desempeño academ. favorable",ces.Plan_Medico as "intervención médico  indiv.", ces.Meta_PII as "Desc.meta trazada en el PII",ces.Informe_Tecnico as "Posee inf.técnico evolutivo", ces.Des_Informe as "Desc. del informe evolutivo",ces.Cumple_Plan as "Cumpl.plan de intervención", ces.Enfermedades_Cronicas as "Enfermedades crónicas degen.",ces.Especificar as "Especificar la enfermedad",ctf.Plan_Medico as "intervención médico indiv.",ctf.Meta_PII as "Desc meta trazada en el PII", ctf.Informe_Tecnico as "Posee info. técnico evolutivo",ctf.Des_Informe as "Desc. del info. evolutivo", ctf.Cumple_Plan as "Cumpl. plan de intervención", ctf.Desarrollo_Lenguaje as "Desarrollo de capac.lenguaje",ctf.Mejora_Fonema as "Mejora emisión de fonemas",ctf.Mejora_Comprensivo as "Mejora lenguaje comprensivo",ctf.Elabora_Oraciones as "Construc./elabora. oraciones", cen.Plan_Nutricional as "posee plan nutricional",cen.Meta_PII as "Descr.meta trazada en el PII",cen.Informe_Tecnico as "Posee infor. técn. evolutivo",cen.Des_Informe as "Desc informe evolutivo", cen.Cumple_Plan as "Cumplim. plan intervención",cen.Estado_Nutricional as "Estado Nutricional(IMC)", cen.Peso as "Peso(Kg. )", cen.Talla as "Talla(m )", cen.Hemoglobina as "Hemoglobina (gr./dl)",cets.Plan_Social as "Plan Intervención Social",cets.Meta_PII as "Des meta trazada en el PAI",cets.Informe_Tecnico as "Posee informe técn.evolutivo",cets.Des_Informe as "Descrip. del info. evolutivo", cets.Cumple_Plan as "Cumplim. plan de intervención", cets.Ubicacion_Familia as "Ubicación de la familia", cets.Participacion_Familia as "Participación activa familia",cets.Reinsercion as "Posibilidad de Reinserción", cets.Colocacion_Laboral as "Posib. Colocación Laboral",ceg.Fecha_Egreso,ceg.Motivo_Egreso as "Motivo del Egreso",ceg.Retiro_Voluntario as "Retiro Voluntario",ceg.Reinsercion as "Reinserción Familiar.",ceg.Grado_Parentesco as "Grado de Parentesco", ceg.Traslado as "Traslado", ceg.Fallecimiento, ceg.Restitucion_Derechos as "Cump.restitu.derechos egreso", ceg.Aus as "AUS",ceg.Constancia_Naci as "Constancia de NAcimiento", ceg.Carnet_CONADIS as "Carnet del CONADIS",ceg.DNI,ceg.Restitucion as "Restitución Familiar",re.PIDE  from 
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
        where cu.residente_id(+)=re.id and ca.id(+)= re.centro_id and cda.residente_id(+)=re.id and cci.residente_id(+)=re.id and csn.residente_id(+)=re.id and csm.residente_id(+)=re.id and ct.residente_id(+)=re.id and cac.residente_id(+)=re.id and cap.residente_id(+)=re.id and cec.residente_id(+)=re.id and cts.residente_id(+)=re.id and cas.residente_id(+)=re.id and cep.residente_id(+)=re.id and cee.residente_id(+)=re.id and ces.residente_id(+)=re.id and ctf.residente_id(+)=re.id and cen.residente_id(+)=re.id and cets.residente_id(+)=re.id and ceg.residente_id(+)=re.id and re.tipo_centro_id=1 and ( (to_char(cu.fecha_creacion(+),\'DD-MON-YY\') '.$fecha.') and (to_char(ca.fecha_creacion(+),\'DD-MON-YY\') '.$fecha.') and (to_char(cda.fecha_creacion(+),\'DD-MON-YY\') '.$fecha.') and (to_char(cci.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(csn.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(csm.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(ct.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(cac.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(cap.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(cec.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(cts.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(cas.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(cep.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(cee.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(ces.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(ctf.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(cen.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(cets.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(ceg.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') ) '.$where),

        '2'=>('select pdi.residente_id as Codigoresidente,\''.($periodo_anio."-".date("F",strtotime($periodo_mes))).'\' as "Periodo",ca.CODIGO_ENTIDAD as "Código de la Entidad",ca.nombre_entidad as "Nombre de la Entidad", ca.codigo_linea as "Código de la Linea" ,ca.linea_intervencion as "Línea de Intervención" , ca.cod_serv as "Código del Servicio" , ca.nom_serv as "Nombre del Servicio", ca.ubigeo as "Ubigeo Según el INEI", (SELECT NOMDEPT FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Departamento Centro Atención", (SELECT NOMPROV FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Provincia Centro Atención", (SELECT NOMDIST FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Distrito Centro Atención",ca.centro_poblado as "C.Poblado centro atención", ca.area_residencia as "Área de Residencia",ca.cod_ca as "Código Centro Atención",ca.nom_ca as "Nombre Centro Atención",ca.fecha_creacion as "Fecha de Registro",
        
        pdi.residente_apellido_paterno as "Apellido Paterno", pdi.residente_apellido_materno as "Apellido Materno",pdi.residente_nombre as "Nombre Usuario",(SELECT nombre FROM paises WHERE id=pdi.pais_procedente_id) as "País de Procedencia",
        (SELECT NOMDEPT FROM ubigeo WHERE CODDEPT=pdi.departamento_procedente_id group by nomdept) as "Departamento Proc. Usuario",(SELECT NOMDEPT FROM ubigeo WHERE CODDIST=pdi.distrito_nacimiento_id) as "Departamento Naci. Usuario", (SELECT NOMPROV FROM ubigeo WHERE CODDIST=pdi.distrito_nacimiento_id ) as "Provincia Usuario", (SELECT NOMDIST FROM ubigeo WHERE CODDIST=pdi.distrito_nacimiento_id ) as "Distrito Usuario", pdi.sexo, pdi.fecha_nacimiento as "Fecha de Nacimiento",pdi.edad,(SELECT nombre FROM pam_lengua_materna where id=pdi.lengua_materna) as "Lengua Materna",
        
        pdau.movimiento_poblacional as "Movimiento Poblacional", pdau.fecha_ingreso_usuario as "Fecha de Ingreso del Usuario",(SELECT nombre FROM pam_instituciones_deriva where id=pdau.institucion_deriva) as "Institución que lo Derivó",(SELECT nombre FROM pam_motivos_ingreso where id =pdau.motivo_ingreso_principal) as "Mótivo de Ingreso PRIN(EXP)", (SELECT nombre FROM pam_motivos_ingreso where id =pdau.motivo_ingreso_secundario) as "Mótivo de Ingreso SEC(EXP)",pdau.perfil_ingreso as "Perfil de Ingreso",pdau.tipo_documento_ingreo_car as "T.Documento Ingreso ,CAR",pdau.numero_documento_ingreo_car as "Número documento ingreso CAR",
        
        pdci.documento_entidad as "Documento Identifdad ingreso", pdci.tipo_documento_entidad as "Tipo doc. identidad INGRESO", pdci.numero_documento_ingreso as "Número del documento",pdci.leer_escribir as "Usuario sabe Leer y Escribir",(SELECT nombre FROM pam_nivel_educativo WHERE id = pdci.nivel_educativo and codigo=\'pam\') as "Nivel Educativo",pdci.aseguramiento_salud as "Tipo de seguro de salud",pdci.tipo_pension as "Tipo de pensión que percibe",(SELECT nombre FROM pam_clasif_socioeconomico WHERE id=pdci.SISFOH ) as "Clasificación Socioeconómica", pdci.familiar_ubicados as "Familiares Ubicados",pdci.tipo_parentesco as "Tipo de parentesco",
        
        
        pds.discapacidad,pds.discapacidad_fisica as "Presenta Discap. Física",pds.discapacidad_intelectual as "Presenta Discap. Intelectual",pds.discapacidad_sensorial  as "Presenta Discap. Sensorial",pds.presenta_discapacidad_mental as "Presenta Discap. Mental",pds.dx_certificado as "El Dx es certificado", pds.carnet_conadis "Tiene carnet del CONADIS",pds.grado_dependencia_pam as "Grado Dependencia PAM", pds.motivo_dif_desplazamiento as "Motivo de dif. desplazamiento",pds.enfermedad_ingreso_1 as "Enfermedad de ingreso 1", (SELECT nombre FROM pam_tipo_patologia where id =pds.tipo_patologia) as "Tipo de patología" ,pds.enfermedad_ingreso_2 as "Enfermedad de Ingreso 2",(SELECT nombre FROM pam_tipo_patologia where id =pds.tipo_patologia_2) as "Tipo de patología 2",pds.nivel_hemoglobina as "Nivel de Hemoglobina",pds.presenta_anema as "Presenta Anemia",pds.peso as "Peso(Kg.)", pds.talla as "Talla(m)", pds.estado_nutricional as "Estado nutricional (imc)",
        
        psm.trastorno_disociales as "Trast.compor. y/o disociales",psm.tipo_trastorno as "Tipo de Trastorno",
        
        pasc.Terapia_Fisica_Rehabilitacion as "Terap.Fisica y Rehabilitación",pasc.Arte as "Arte (Musica, danza, teatro)",pasc.Nro_Arte as "n° participa Arte en el mes", pasc.Dibujo_Pintura as "Dibujo y pintura",pasc.Nro_Arte_Dibujo_Pintura as "N° participa en Arte",pasc.Manualidades,pasc.Nro_Arte_Manualidades as "N° Participa en Arte.",pasc.Otros as "Otros",pasc.Nro_Arte_Otros as "Veces Participa en Arte",
        
        pap.Atencion_Psicologica as "atención psicológica",pap.Habilidades_Sociales as "T.Habilidades Sociales",pap.Nro_Participa  as "Nº Veces Participa",pap.Taller_Autoestima  as "Taller de autoestima",pap.Nro_Participa_Autoestima  as "N° Veces que participa",pap.ManejoSituacionesDivergentes  as "T.Man. Situaciones Diverg.",pap.Nro_Participa_Divergentes as "Nro Veces Participa",pap.Taller_Control_Emociones as "T.Control de Emociones",pap.Nro_Participa_Emociones as "Nª Veces Participa", pap.ConservacionHabilidadCognitiva as "T.Conserv.Habilidades Cognit.",pap.Nro_Participa_Cognitivas as "N° Participa Taller", pap.Otros as "Otros.",pap.Nro_Participa_Otros as "Nro Veces Participa Otros",
        
        pas.Atencion_Social as "Atención Social",pas.Visita_Familiares as "Visitas Familiares",pas.Nro_Visitas as "N° Visitas en el mes",pas.Visitas_Amigos as "Visitas Amigos", pas.Nro_Visitas_Amigos as "Nro Visitas de Amigos en Mes",pas.Descriptivo_Persona_Visita as "Desc. persona que los visita",pas.Aseguramiento_Universal_Salud as "Aseguramiento Universal Salud",pas.Fecha_Emision_Obtencion_Seguro as "Fecha emi. obtención seguro",pas.DNI as "Doc. Nacional Identidad -DNI",pas.Fecha_Emision_DNI as "Fecha de emisión del DNI",
        
       pasa.Residente_Salida as "Salidas a hospitales al mes",pasa.Salidas as "N° salidas a hospitales", pasa.Atenciones_Cardiovascular as "N° Atenciones CArdiovascular",pasa.Atenciones_Nefrologia as "N° Atenciones nefrología",pasa.Atenciones_Oncologia as "N° Atenciones Oncología",pasa.Atenciones_Neurocirugia as "N° Atenciones Neurocirugía",pasa.Atenciones_Dermatologia as "N° Atenciones dermatología",pasa.Atenciones_Endocrinologo as "N° Atenciones Endocrinología",pasa.Atenciones_Gastroenterologia as "N° Atenc. gastroenterología",pasa.Atenciones_Hematologia as "N° Atenciones hematología",pasa.Atenciones_Inmunologia as "N° Atenciones Inmunología",pasa.AtencionesMedicFisiRehabilita as "N° Atenc.Medi.Física Rehabi.",pasa.Atenciones_Neumologia as "N° Atenciones neumología",pasa.Atenciones_Nutricion as "N° Atenciones Nutrición",pasa.Atenciones_Neurologia as "N° Atenciones Neurología",pasa.Atenciones_Oftalmologia as "N° Atenciones oftalmología", pasa.AtencionOtorrinolaringologia as "N°Atenc.OTORRINOLARINGOLOGIA",pasa.Atenciones_Psiquiatria as "N° Atenciones psiquiatría",pasa.Atenciones_Traumatologia as "N° Atenciones traumatología", pasa.Atenciones_Urologia as "N° Atenciones urología",pasa.Atenciones_Odontologia as "N° Atenciones odontología",pasa.MedicinaGeneral_Geriatrica as "Medic. general y/o Geriatrica",pasa.Nro_Atenciones_OtrosServicios as "Nº Atenc. en Otros servicios",pasa.ResidenteHospitalizadoPeriodo as "hospitalizado en el periodo",pasa.Motivo_Hospitalizacion as "Motivo de la hospitalización"
       
       ,pps.Plan_Intervencion as "Posee Plan Intervenc. Psico.", pps.Des_Meta as "Desc Meta Trazada PAI",pps.Informe_Tecnico as "Posee info. técnico evolutivo",pps.Des_Informe_Tecnico as "Desc.Infor.Evolutivo",pps.Cumple_Intervencion as "Cumple Plan Intervención",pps.Deterioro_Cognitivo as "Deteriorio del área cognitiva",pps.Transtorno_Depresivo as "Presencia transtor. depresivo", pps.Severidad_Trans_Depresivo as "Severidad transtor. depresivo",
       
       ps.Plan_Intervencion as "Posee Plan Intervención.", ps.Meta_PAI as "Des.Meta Trazada en el PAI", ps.Informe_Tecnico as "Posee info. técnic. evolutivo",ps.Des_Informe_Tecnico as "Descr. del informe evolutivo", ps.Cumple_Intervencion as "Cump. plan de intervención",ps.Grado_PAM as "Grado dependencia de las PAM",ps.EnfermedaCronicasDegenerativas as "Enfermed. crónicas degenerat.",ps.Especificar_Enfermedad as "Especificar Enfermedad",
       
       pn.Plan_Intervencion as "posee plan nutricional",pn.Meta_PAI as "Des meta trazada en el PAI",pn.Informe_Tecnico as "Posee inf. técnico evolutivo",pn.Des_Informe_Tecnico as "Des del informe evolutivo", pn.Cumple_Intervencion as "Cump. plan de intervención.",pn.Estado_Nutricional_IMC as "Estado Nutricional(IMC)", pn.Peso as "Peso(Kg. )", pn.Talla as "Talla(m )", pn.Hemoglobina as "Hemoglobina (gr./dl)"
       ,
       pt.Plan_Intervencion as "plan interv. Trabajo Social", pt.Meta_PAI as "Meta trazada en el PAI.", pt.Informe_Tecnico as "Informe técnico evolutivo",pt.Des_Informe_Tecnico as "Des Informe evolutivo",pt.Cumple_Intervencion as "Cump.plan de intervención",
       
       peu.Fecha_Egreso,peu.MotivoEgreso as "Motivo del Egreso",peu.Retiro_Voluntario as "Retiro Voluntario",peu.Reinsercion_Familiar as "Reinserción Familiar",peu.Traslado_Entidad_Salud as "Traslado a una entidad salud", peu.Traslado_Otra_Entidad as "Traslado a otra entidad", peu.Fallecimiento, peu.RestitucionAseguramientoSaludo as "Cump.rest.derechos.Aseg.Salud", peu.Restitucion_Derechos_DNI as "Cump.restit. de derechos -DNI", peu.RestitucionReinsercionFamiliar as "Cump.restit.Reinser. Familiar"

        from 
        pam_datos_identificacion pdi 
        ,pam_datos_admision_usuario pdau 
        ,pam_datosCondicionIngreso pdci
        ,pam_datos_saludnutric pds
        ,pam_salud_mental psm 
        ,pam_ActividadSociorecrea pasc 
        ,pam_ActividadPrevencion pap  
        ,pam_ActividadesSociales pas 
        ,pam_AtencionesSalud pasa 
        ,pam_Psicologico pps 
        ,pam_Salud ps 
        ,pam_nutricion pn 
        ,pam_trabajoSocial pt 
        ,pam_EgresoUsuario peu 
        ,centro_atencion ca 
        ,residente re
        where pdi.residente_id(+)=re.id and ca.id(+)= re.centro_id and pdau.residente_id(+)=re.id and pdci.residente_id(+)=re.id and pds.residente_id(+)=re.id and psm.residente_id(+)=re.id and pasc.residente_id(+)=re.id and pap.residente_id(+)=re.id and pas.residente_id(+)=re.id and pasa.residente_id(+)=re.id and pps.residente_id(+)=re.id and ps.residente_id(+)=re.id and pn.residente_id(+)=re.id and pt.residente_id(+)=re.id and peu.residente_id(+)=re.id and     re.tipo_centro_id=2 and ( (to_char(pdi.fecha_creacion(+),\'DD-MON-YY\') '.$fecha.') and (to_char(ca.fecha_creacion(+),\'DD-MON-YY\') '.$fecha.') and (to_char(pdau.fecha_creacion(+),\'DD-MON-YY\') '.$fecha.') and (to_char(pdci.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(pds.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(psm.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(pasc.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(pap.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(pas.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(pasa.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(pps.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(ps.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(pn.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(pt.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(peu.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') ) '.$where),
        
        '3'=>('select nir.residente_id as Codigoresidente,\''.($periodo_anio."-".date("F",strtotime($periodo_mes))).'\' as "Periodo",ca.CODIGO_ENTIDAD as "Código de la Entidad",ca.nombre_entidad as "Nombre de la Entidad", ca.codigo_linea as "Código de la Linea" ,ca.linea_intervencion as "Línea de Intervención" , ca.cod_serv as "Código del Servicio" , ca.nom_serv as "Nombre del Servicio", ca.ubigeo as "Ubigeo Según el INEI", (SELECT NOMDEPT FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Departamento Centro Atención", (SELECT NOMPROV FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Provincia Centro Atención", (SELECT NOMDIST FROM ubigeo WHERE CODDIST=ca.ubigeo) as "Distrito Centro Atención",ca.centro_poblado as "C.Poblado centro atención", ca.area_residencia as "Área de Residencia",ca.cod_ca as "Código Centro Atención",ca.nom_ca as "Nombre Centro Atención",ca.fecha_creacion as "Fecha de Registro",nir.residente_apellido_paterno as "Apellido Paterno", nir.residente_apellido_materno as "Apellido Materno",nir.residente_nombre as "Nombre Usuario",(SELECT nombre FROM paises WHERE id=nir.pais_procedente_id) as "País de Procedencia",(SELECT NOMDEPT FROM ubigeo WHERE CODDIST=nir.distrito_nacimiento_id) as "Departamento Usuario", (SELECT NOMPROV FROM ubigeo WHERE CODDIST=nir.distrito_nacimiento_id ) as "Provincia Usuario", (SELECT NOMDIST FROM ubigeo WHERE CODDIST=nir.distrito_nacimiento_id ) as "Distrito Usuario", nir.sexo, nir.fecha_nacimiento as "Fecha de Nacimiento", 
        
        nar.Movimiento_Poblacional as "Movimiento Poblacional",nar.Fecha_Ingreso as "Fecha de Ingreso del Usuario",nar.Fecha_Registro as "Fecha de Reingreso",(SELECT nombre FROM nna_instituciones where id=nar.Institucion_Derivacion) as "Institución que lo Derivó",(SELECT nombre FROM nna_motivos_ingreso where id =nar.Motivo_Ingreso) as "Mótivo de Ingreso",(SELECT nombre FROM nna_perfiles_ingreso WHERE id=nar.Perfil_Ingreso_P) as "PRINCIPAL PERFIL ING.primario",(SELECT nombre FROM nna_perfiles_ingreso WHERE id=nar.Perfil_Ingreso_S) as "PRINCIPAL PERFIL ING.secund.", nar.Tipo_Doc as "T.Documento Ingreso CAR", nar.Numero_Doc as "Número documento ingreso CAR",nar.Situacion_Legal as "Situación Legal",
        
        nci.Tipo_Doc as "Tipo documento identidad", nci.Numero_Doc as "Número Documento Identidad",nci.Lee_Escribe as "sabe Leer y Escribir",(SELECT nombre FROM pam_nivel_educativo WHERE id = nci.Nivel_Educativo and codigo=\'pam\') as "Nivel Educativo",(SELECT nombre FROM pam_tipo_seguro_salud where id=nci.Tipo_Seguro) as "Tipo de seguro de salud",(SELECT nombre FROM pam_clasif_socioeconomico WHERE id=nci.SISFOH ) as "Clasificación Socioeconómica",     

        nfr.Familiares as "Familiares Ubicados",(SELECT nombre FROM pam_tipo_parentesco where id=nfr.Parentesco and codigo=\'ppd\') as "Tipo de parentesco",nfr.Tipo_Familia as "Tipo de Familia",(SELECT nombre FROM Nnaproblematica_familiar where id=nfr.Problematica_Fami) as "Problemática Familiar",


        nds.Discapacidad,nds.Discapacidad_Fisica as "Presenta Discap. Física",nds.Discapaciada_Intelectual as "Presenta Discap. Intelectual",nds.Discapacidad_Sensorial  as "Presenta Discap. Sensorial",nds.Discapacidad_Mental as "Presenta Discap. Mental",nds.Certificado as "El Dx es certificado", nds.Carnet_CANADIS "Tiene carnet del CONADIS",nds.Transtornos_Neuro as "Trastornos Neurológico",nds.Des_Transtorno_Neuro as "Especif.Trastorno Neurológico", nds.CRED as "Atenciones CRED",nds.Vacunas as "Recibió Vacunas", nds.Patologia_1 as "patología crónica 1",nds.Diagnostico_S1 as "Diagnósticos 1 según CIE 10",nds.Patologia_2 as "Patología Crónica 2",nds.Diagnostico_S3 as "Diagnósticos 3 según CIE 10",nds.Transtornos_Comportamiento as "Tr.Comportamiento/disociales",
        nds.Tipo_Transtorno as "Tipo de Trastorno",nds.Gestante,nds.Semanas_Gestacion as "Semanas de Gestación",nds.Control_Prenatal as "Acudido Control Parental",nds.Hijos as "NNA tiene hijos", nds.Nro_Hijos as "Número de hijos en CAR",
        nds.Nivel_Hemoglobina as "Nivel de Hemoglobina",nds.Anemia as "Presenta Anemia",nds.Peso as "Peso(Kg.)", nds.Talla as "Talla(m)", nds.Estado_Nutricional1 as "Estado nutricional 1(imc)",nds.Estado_Nutricional2 as "Estado nutricional 2(imc)" ,

         nts.Fase_Intervencion as "Fase de Intervención",nts.Estado_Usuario as "Estado del Usuario",nts.Plan_Intervencion  as "Plan Intervención",nts.SituacionL_NNA  as "Situación Legal NNA",nts.Familia_NNA  as "¿Cuenta con Familia Ubicada?",nts.SoporteF_NNA  as "NNa Cuenta Soporte FAmiliar",nts.Des_SoporteF as "Persona brindan sop. familiar",nts.Tipo_Familia as "Tipo de Familia.",nts.Problematica_Fami as "Problemática Familiar.", nts.NNA_Soporte_Fami as "NNA brindan sop. familiar",nts.Familia_SISFOH as "Familia Cuenta SISFOH", nts.Resultado_Clasificacion as "Resultado Clasificación",nts.Nro_VisitasNNA as "visitas fami. recibe cada NNA",nts.Participacion_EscuelaP as "N.Partici. Escuelas de Padres",nts.Consegeria_Familiar as "Consejerías/orientac. familia",nts.Soporte_Social as "Fami. usa redes sop. social",nts.Consejeria_Residentes as "N° Consej./orienta. Residente",nts.Charlas as "Nº Charlas Preven. - Promo.",nts.Visitas_Domicilarias as "Nº Visitas Domiciliarias", nts.Reinsercion_Familiar as "Plan de Reinserción familiar",nts.DNI as "Residente cuenta con DNI",nts.AUS_SIS as "Residente cuenta con AUS/SIS", nts.CONADIS as "Residen cuenta carnet CONADIS",

         nas.Nro_Arte as "N°Arte (Musica,danza,teatro)",nas.Nro_BioHuerto as "N° Biohuerto",nas.Nro_Zapateria as "N° Calzado y Zapatería",nas.Nro_Carpinteria as "N.Carpintería/Tallad.madera", nas.Nro_Ceramica as "N° Cerámica",nas.Nro_Crianza as "n° crianza animales",nas.Nro_Dibujo as "N° Dibujo y pintura.",nas.Nro_Tejido as "N° Tejidos y Telares",nas.Nro_Deportes as "N° Deporte - Entre otros",nas.Nro_Taller_Pro as "Talleres Productivos",

         ns.Intervencion as "Plan de intervención de salud",(SELECT nombre FROM diag_psiquiatrico_cie_10 where id =ns.Diagnostico_Psiquiatrico_1) as "Diag.Psiquiátr. 1 (CIE-10)",
         (SELECT nombre FROM diag_psiquiatrico_cie_10 where id =ns.Diagnostico_Psiquiatrico_2) as "Diag.Psiquiátr. 2 (CIE-10)",
         (SELECT nombre FROM diag_psiquiatrico_cie_10 where id =ns.Diagnostico_Psiquiatrico_3) as "Diag.Psiquiátr. 3 (CIE-10)",
 
         (SELECT nombre FROM diag_neurologico_cie_10 where id =ns.Diagnostico_Neurologico_1) as "Diag.Neurológ. 1 (CIE-10)",
         (SELECT nombre FROM diag_neurologico_cie_10 where id =ns.Diagnostico_Neurologico_2) as "Diag.Neurológ. 2 (CIE-10)",
         (SELECT nombre FROM diag_neurologico_cie_10 where id =ns.Diagnostico_Neurologico_3) as "Diag.Neurológ. 3 (CIE-10)",
 
         (SELECT nombre FROM diag_cronico_cie_10 where id =ns.Diagnostico_Cronico_1) as "Diag.Crónico. 1 (CIE-10)",
         (SELECT nombre FROM diag_cronico_cie_10 where id =ns.Diagnostico_Cronico_2) as "Diag.Crónico. 2 (CIE-10)",
         (SELECT nombre FROM diag_cronico_cie_10 where id =ns.Diagnostico_Cronico_3) as "Diag.Crónico. 3 (CIE-10)",
 
         (SELECT nombre FROM diag_agudo_cie_10 where id =ns.Diagnostico_Agudo_1) as "Diag.Agudo. 1 (CIE-10)",
         (SELECT nombre FROM diag_agudo_cie_10 where id =ns.Diagnostico_Agudo_2) as "Diag.Agudo. 2 (CIE-10)",
         (SELECT nombre FROM diag_agudo_cie_10 where id =ns.Diagnostico_Agudo_3) as "Diag.Agudo. 3 (CIE-10)",
 
         ns.VIH as "Residente presenta VIH",ns.ETS as "Residente presenta ETS",ns.TBC as "TBC",ns.HepatitisA as "Residente presen. HEPATITIS A",ns.HepatitisB as "Residente presen. HEPATITIS B",ns.Caries as "Residente presenta Caries",ns.Discapacidad,ns.Discapacidad_Fisica as "Presenta discapacidad física",ns.Discapacidad_Intelectual as "Presenta discap. intelectual.",ns.Discapacidad_Sensorial as "Presenta discap. sensorial.",ns.Discapacidad_Mental as "Presenta discap. mental.",ns.SIS,ns.ESSALUD,ns.Tipo_Seguro as "Otro tipo de Seguro de Salud",ns.CONADIS, ns.A_Medicina_General as "Nº Atención Medicina General",ns.A_Cirujia_General as "Nº Atención Cirugía General",ns.A_Traumatologia as "N° Atencion traumatología",
         ns.A_Odontologia as "N° Atencion odontología",ns.A_Medicina_Interna as "N° Atencion Med.Interna",ns.A_Cardiovascular as "N° Atencion Cardiovascular",ns.A_Dermatologia as "N° Atencion Dematología",ns.A_Endrocrinologia as "N° Atencion Endocrinología", ns.A_Gastroentrologia as "N° Aten. Gastroenterología",
         
         ns.A_Gineco_Obstetricia as "N° Atenc.gineco-obstetricia",ns.A_Hermatologia as "N° Atencion hematología", ns.A_Nefrologia as "N° Atención Nefrología" ,
         ns.A_Infectologia as "N° Atenc. Infectología",ns.A_Inmunologia as "N° Atenc.Inmunología",ns.A_Reumatologia as "N° Atención Reumatología.",ns.A_Neumologia as "N° Atenciones Neumología",ns.A_Neurologia as "N° Atencion Neurología",ns.A_Oftalmologia as "N° Atencion oftalmología", ns.A_Otorrinolaringologia as "N°Atenc.OTORRINOLARINGOLOGIA",ns.A_Oncologia as "N° Atencion Oncología",ns.A_Psicriatica as "N° Atencion psiquiatría",ns.A_Cirujia as "N° Atencion cirugía", ns.A_Urologia as "N° Atencion urología",ns.A_Nutricion as "N° Atencion nutrición",ns.A_Pedriatria as "Nº Atención Pedriatría/CRED",ns.A_Rehabilitacion as "Nº Aten.Medic. Física/Rehab",ns.A_Gineco_Menores as "Nº Atenc. Ginecología Menor",ns.A_Psicologia as "Nº Atención en Psicología",ns.Atencion_Total as "Sumar atenciones",ns.Hospitalizado as "Usuario hospitalizado",ns.Emergencia as "Aten. Emergencia hospitales",ns.CRED as "Inscrito en CRED",ns.Inmunizacion as "Carné de inmunización"
           
         
          
        

        from 
        NNAInscripcionResidente nir 
        ,NNAAdmisionResidente nar 
        ,NNACondicionIResidente nci
        ,NNAFamiliaresResidente nfr
        ,NNADatosSaludResi nds  
 ,NNATrabajoSocial nts  

 ,NNAActividadesSociorecrea nas 
 ,NNASalud ns 
        ,centro_atencion ca 
        ,residente re
        where nir.residente_id(+)=re.id and ca.id(+)= re.centro_id and nar.residente_id(+)=re.id and nci.residente_id(+)=re.id and nfr.residente_id(+)=re.id and nds.residente_id(+)=re.id and nts.residente_id(+)=re.id and nas.residente_id(+)=re.id and ns.residente_id(+)=re.id and  re.tipo_centro_id=3 and ( (to_char(nir.fecha_creacion(+),\'DD-MON-YY\') '.$fecha.') and (to_char(ca.fecha_creacion(+),\'DD-MON-YY\') '.$fecha.') and (to_char(nar.fecha_creacion(+),\'DD-MON-YY\') '.$fecha.') and (to_char(nci.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(nfr.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and  (to_char(nds.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(nts.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(nas.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.') and (to_char(ns.fecha_creacion(+),\'DD-MON-YY\')  '.$fecha.'))  '.$where));

?>