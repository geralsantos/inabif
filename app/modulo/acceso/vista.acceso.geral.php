<form action="geral" method="POST">
<input type="text" value="" name="nombretabla" placeholder="tabla">
<button type="submit">mostrar resultados</button></form>
<?php 
//  Configure DB Parameters
class mdl
{
    public function createTable ($sql){
        try {
            echo "creando..."."</br>";
            echo $sql."</br>";
            $db1 = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.19.0.35)(PORT = 1521)))(CONNECT_DATA=(SID=xe)))" ;
            $host = "172.19.0.35";
            $dbname = "orcl";
            $dbuser = "INABIF_UPP";
            $userpass = "UPP";
            $port= 1521;
    
            $db = new PDO("oci:dbname=$db1",$dbuser,$userpass);
            $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
         
            $db->exec($sql);
            print("tabla creada "."</br>");
       
       } catch(PDOException $e) {
           echo $e->getMessage();//Remove or change message in production code
       }
    }
}
class PG extends PDO
{
public function __construct() {
    $db1 = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 172.19.0.35)(PORT = 1521)))(CONNECT_DATA=(SID=xe)))" ;
        $host = "172.19.0.35";
        $dbname = "orcl";
        $dbuser = "INABIF_UPP";
        $userpass = "UPP";
        $port= 1521;
         //parent::__construct("oci:dbname=//$host:$port/$dbname;charset=utf8",$dbuser,$userpass);
         parent::__construct("oci:dbname=$db1".";charset=UTF8",$dbuser,$userpass);
    try {

 
      parent::setAttribute(parent::ATTR_ERRMODE, parent::ERRMODE_EXCEPTION);

      parent::setAttribute(parent::ATTR_DEFAULT_FETCH_MODE, parent::FETCH_ASSOC);

      //parent::exec("SET CHARACTER SET utf8");

    } catch (PDOException $e) {

        echo 'Error BD: ' . $e->getMessage();

      }

    }
    public function dropTable($query){

        try{
            echo "ELIMINANDO... ".$query."</br>";
          $stmt = parent::prepare($query);
          if($stmt->execute()){
            echo "borrado";
          }else{
            echo "no borrado";
          }
        echo "<br>";
        } catch (PDOException $e) {
          echo 'Error BD: ' . $e->getMessage();
        }
      }
public function executeQuery($query, $params=NULL){

      try{

        $stmt = parent::prepare($query);

        if($stmt->execute($params)){
            echo "executeQuery";
          return $stmt->fetchAll();

        }else{

          return array();

        }

      } catch (PDOException $e) {

        echo 'Error BD: ' . $e->getMessage();

      }

    }
    public function insertData($tabla, $values) {
        if(count($values)>0){
            $query = 'INSERT INTO '.$tabla;
            $queryKeys = '';
            $queryValues = '';
            $params = array();
            $coma = '';
            foreach($values as $key => $val){
                $queryKeys .= $coma.$key;
                $queryValues .= $coma.':'.$key;
                $params[':'.$key] = $val;
                $coma = ',';
            }
            $query .= '('.$queryKeys.') VALUES ('.$queryValues.')';
            print_r($query);
            $stmt = parent::prepare($query);
            $stmt->execute($params);
            if($stmt->rowCount()>0){
                return TRUE;
            }else{
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }
    public function deleteDataNoWhere($tabla) {
        $query = 'DELETE FROM ' . $tabla;
        $params = array();
        $stmt = parent::prepare($query);
        $stmt->execute($params);
        echo "borrado: ".$tabla;
        if($stmt->rowCount()>0){
            return TRUE;
        }else{
            return FALSE;
        }

}
    }

$x = new PG();
$mdl = new mdl();
if (isset($_GET["deletedata"])) {
    $x->deleteDataNoWhere("CarDatosAdmision");
    $x->deleteDataNoWhere("CarAtencionPsicologica");
    $x->deleteDataNoWhere("CarAtencionSalud");
    $x->deleteDataNoWhere("CarActividades");
    $x->deleteDataNoWhere("CarTrabajoSocial");
    $x->deleteDataNoWhere("CarCentroServicio");
    $x->deleteDataNoWhere("CarIdentificacionUsuario");
    $x->deleteDataNoWhere("CarCondicionIngreso");
    $x->deleteDataNoWhere("CarEgresoEducacion");
    $x->deleteDataNoWhere("CarEgresoGeneral");
    $x->deleteDataNoWhere("CarEgresoSalud");
    $x->deleteDataNoWhere("CarTerapiaFisica");
    
    die();
}
if (isset($_POST["nombretabla"]) && $_POST["nombretabla"]!="") {
    echo "SELECT * FROM ".$_POST["nombretabla"]." WHERE ESTADO=1";
    echo "<br>";
    print_r($x->executeQuery("SELECT * FROM ".$_POST["nombretabla"]." "));
    die();
}else{
    $x->dropTable('drop table paises ');
$mdl->createTable("CREATE TABLE paises(
    id int primary key,
    iso char(2) default NULL,
    nombre varchar(128) default NULL,
    estado int default 1
  )"); 

$paises = ["INSERT INTO paises (id,iso,nombre) VALUES(1, 'AF', 'Afganistán')","
","INSERT INTO paises (id,iso,nombre) VALUES(2, 'AX', 'Islas Gland')","
","INSERT INTO paises (id,iso,nombre) VALUES(3, 'AL', 'Albania')","
","INSERT INTO paises (id,iso,nombre) VALUES(4, 'DE', 'Alemania')","
","INSERT INTO paises (id,iso,nombre) VALUES(5, 'AD', 'Andorra')","
","INSERT INTO paises (id,iso,nombre) VALUES(6, 'AO', 'Angola')","
","INSERT INTO paises (id,iso,nombre) VALUES(7, 'AI', 'Anguilla')","
","INSERT INTO paises (id,iso,nombre) VALUES(8, 'AQ', 'Antártida')","
","INSERT INTO paises (id,iso,nombre) VALUES(9, 'AG', 'Antigua y Barbuda')","
","INSERT INTO paises (id,iso,nombre) VALUES(10, 'AN', 'Antillas Holandesas')","
","INSERT INTO paises (id,iso,nombre) VALUES(11, 'SA', 'Arabia Saudí')","
","INSERT INTO paises (id,iso,nombre) VALUES(12, 'DZ', 'Argelia')","
","INSERT INTO paises (id,iso,nombre) VALUES(13, 'AR', 'Argentina')","
","INSERT INTO paises (id,iso,nombre) VALUES(14, 'AM', 'Armenia')","
","INSERT INTO paises (id,iso,nombre) VALUES(15, 'AW', 'Aruba')","
","INSERT INTO paises (id,iso,nombre) VALUES(16, 'AU', 'Australia')","
","INSERT INTO paises (id,iso,nombre) VALUES(17, 'AT', 'Austria')","
","INSERT INTO paises (id,iso,nombre) VALUES(18, 'AZ', 'Azerbaiyán')","
","INSERT INTO paises (id,iso,nombre) VALUES(19, 'BS', 'Bahamas')","
","INSERT INTO paises (id,iso,nombre) VALUES(20, 'BH', 'Bahréin')","
","INSERT INTO paises (id,iso,nombre) VALUES(21, 'BD', 'Bangladesh')","
","INSERT INTO paises (id,iso,nombre) VALUES(22, 'BB', 'Barbados')","
","INSERT INTO paises (id,iso,nombre) VALUES(23, 'BY', 'Bielorrusia')","
","INSERT INTO paises (id,iso,nombre) VALUES(24, 'BE', 'Bélgica')","
","INSERT INTO paises (id,iso,nombre) VALUES(25, 'BZ', 'Belice')","
","INSERT INTO paises (id,iso,nombre) VALUES(26, 'BJ', 'Benin')","
","INSERT INTO paises (id,iso,nombre) VALUES(27, 'BM', 'Bermudas')","
","INSERT INTO paises (id,iso,nombre) VALUES(28, 'BT', 'Bhután')","
","INSERT INTO paises (id,iso,nombre) VALUES(29, 'BO', 'Bolivia')","
","INSERT INTO paises (id,iso,nombre) VALUES(30, 'BA', 'Bosnia y Herzegovina')","
","INSERT INTO paises (id,iso,nombre) VALUES(31, 'BW', 'Botsuana')","
","INSERT INTO paises (id,iso,nombre) VALUES(32, 'BV', 'Isla Bouvet')","
","INSERT INTO paises (id,iso,nombre) VALUES(33, 'BR', 'Brasil')","
","INSERT INTO paises (id,iso,nombre) VALUES(34, 'BN', 'Brunéi')","
","INSERT INTO paises (id,iso,nombre) VALUES(35, 'BG', 'Bulgaria')","
","INSERT INTO paises (id,iso,nombre) VALUES(36, 'BF', 'Burkina Faso')","
","INSERT INTO paises (id,iso,nombre) VALUES(37, 'BI', 'Burundi')","
","INSERT INTO paises (id,iso,nombre) VALUES(38, 'CV', 'Cabo Verde')","
","INSERT INTO paises (id,iso,nombre) VALUES(39, 'KY', 'Islas Caimán')","
","INSERT INTO paises (id,iso,nombre) VALUES(40, 'KH', 'Camboya')","
","INSERT INTO paises (id,iso,nombre) VALUES(41, 'CM', 'Camerún')","
","INSERT INTO paises (id,iso,nombre) VALUES(42, 'CA', 'Canadá')","
","INSERT INTO paises (id,iso,nombre) VALUES(43, 'CF', 'República Centroafricana')","
","INSERT INTO paises (id,iso,nombre) VALUES(44, 'TD', 'Chad')","
","INSERT INTO paises (id,iso,nombre) VALUES(45, 'CZ', 'República Checa')","
","INSERT INTO paises (id,iso,nombre) VALUES(46, 'CL', 'Chile')","
","INSERT INTO paises (id,iso,nombre) VALUES(47, 'CN', 'China')","
","INSERT INTO paises (id,iso,nombre) VALUES(48, 'CY', 'Chipre')","
","INSERT INTO paises (id,iso,nombre) VALUES(49, 'CX', 'Isla de Navidad')","
","INSERT INTO paises (id,iso,nombre) VALUES(50, 'VA', 'Ciudad del Vaticano')","
","INSERT INTO paises (id,iso,nombre) VALUES(51, 'CC', 'Islas Cocos')","
","INSERT INTO paises (id,iso,nombre) VALUES(52, 'CO', 'Colombia')","
","INSERT INTO paises (id,iso,nombre) VALUES(53, 'KM', 'Comoras')","
","INSERT INTO paises (id,iso,nombre) VALUES(54, 'CD', 'República Democrática del Congo')","
","INSERT INTO paises (id,iso,nombre) VALUES(55, 'CG', 'Congo')","
","INSERT INTO paises (id,iso,nombre) VALUES(56, 'CK', 'Islas Cook')","
","INSERT INTO paises (id,iso,nombre) VALUES(57, 'KP', 'Corea del Norte')","
","INSERT INTO paises (id,iso,nombre) VALUES(58, 'KR', 'Corea del Sur')","
","INSERT INTO paises (id,iso,nombre) VALUES(59, 'CI', 'Costa de Marfil')","
","INSERT INTO paises (id,iso,nombre) VALUES(60, 'CR', 'Costa Rica')","
","INSERT INTO paises (id,iso,nombre) VALUES(61, 'HR', 'Croacia')","
","INSERT INTO paises (id,iso,nombre) VALUES(62, 'CU', 'Cuba')","
","INSERT INTO paises (id,iso,nombre) VALUES(63, 'DK', 'Dinamarca')","
","INSERT INTO paises (id,iso,nombre) VALUES(64, 'DM', 'Dominica')","
","INSERT INTO paises (id,iso,nombre) VALUES(65, 'DO', 'República Dominicana')","
","INSERT INTO paises (id,iso,nombre) VALUES(66, 'EC', 'Ecuador')","
","INSERT INTO paises (id,iso,nombre) VALUES(67, 'EG', 'Egipto')","
","INSERT INTO paises (id,iso,nombre) VALUES(68, 'SV', 'El Salvador')","
","INSERT INTO paises (id,iso,nombre) VALUES(69, 'AE', 'Emiratos Árabes Unidos')","
","INSERT INTO paises (id,iso,nombre) VALUES(70, 'ER', 'Eritrea')","
","INSERT INTO paises (id,iso,nombre) VALUES(71, 'SK', 'Eslovaquia')","
","INSERT INTO paises (id,iso,nombre) VALUES(72, 'SI', 'Eslovenia')","
","INSERT INTO paises (id,iso,nombre) VALUES(73, 'ES', 'España')","
","INSERT INTO paises (id,iso,nombre) VALUES(74, 'UM', 'Islas ultramarinas de Estados Unidos')","
","INSERT INTO paises (id,iso,nombre) VALUES(75, 'US', 'Estados Unidos')","
","INSERT INTO paises (id,iso,nombre) VALUES(76, 'EE', 'Estonia')","
","INSERT INTO paises (id,iso,nombre) VALUES(77, 'ET', 'Etiopía')","
","INSERT INTO paises (id,iso,nombre) VALUES(78, 'FO', 'Islas Feroe')","
","INSERT INTO paises (id,iso,nombre) VALUES(79, 'PH', 'Filipinas')","
","INSERT INTO paises (id,iso,nombre) VALUES(80, 'FI', 'Finlandia')","
","INSERT INTO paises (id,iso,nombre) VALUES(81, 'FJ', 'Fiyi')","
","INSERT INTO paises (id,iso,nombre) VALUES(82, 'FR', 'Francia')","
","INSERT INTO paises (id,iso,nombre) VALUES(83, 'GA', 'Gabón')","
","INSERT INTO paises (id,iso,nombre) VALUES(84, 'GM', 'Gambia')","
","INSERT INTO paises (id,iso,nombre) VALUES(85, 'GE', 'Georgia')","
","INSERT INTO paises (id,iso,nombre) VALUES(86, 'GS', 'Islas Georgias del Sur y Sandwich del Sur')","
","INSERT INTO paises (id,iso,nombre) VALUES(87, 'GH', 'Ghana')","
","INSERT INTO paises (id,iso,nombre) VALUES(88, 'GI', 'Gibraltar')","
","INSERT INTO paises (id,iso,nombre) VALUES(89, 'GD', 'Granada')","
","INSERT INTO paises (id,iso,nombre) VALUES(90, 'GR', 'Grecia')","
","INSERT INTO paises (id,iso,nombre) VALUES(91, 'GL', 'Groenlandia')","
","INSERT INTO paises (id,iso,nombre) VALUES(92, 'GP', 'Guadalupe')","
","INSERT INTO paises (id,iso,nombre) VALUES(93, 'GU', 'Guam')","
","INSERT INTO paises (id,iso,nombre) VALUES(94, 'GT', 'Guatemala')","
","INSERT INTO paises (id,iso,nombre) VALUES(95, 'GF', 'Guayana Francesa')","
","INSERT INTO paises (id,iso,nombre) VALUES(96, 'GN', 'Guinea')","
","INSERT INTO paises (id,iso,nombre) VALUES(97, 'GQ', 'Guinea Ecuatorial')","
","INSERT INTO paises (id,iso,nombre) VALUES(98, 'GW', 'Guinea-Bissau')","
","INSERT INTO paises (id,iso,nombre) VALUES(99, 'GY', 'Guyana')","
","INSERT INTO paises (id,iso,nombre) VALUES(100, 'HT', 'Haití')","
","INSERT INTO paises (id,iso,nombre) VALUES(101, 'HM', 'Islas Heard y McDonald')","
","INSERT INTO paises (id,iso,nombre) VALUES(102, 'HN', 'Honduras')","
","INSERT INTO paises (id,iso,nombre) VALUES(103, 'HK', 'Hong Kong')","
","INSERT INTO paises (id,iso,nombre) VALUES(104, 'HU', 'Hungría')","
","INSERT INTO paises (id,iso,nombre) VALUES(105, 'IN', 'India')","
","INSERT INTO paises (id,iso,nombre) VALUES(106, 'ID', 'Indonesia')","
","INSERT INTO paises (id,iso,nombre) VALUES(107, 'IR', 'Irán')","
","INSERT INTO paises (id,iso,nombre) VALUES(108, 'IQ', 'Iraq')","
","INSERT INTO paises (id,iso,nombre) VALUES(109, 'IE', 'Irlanda')","
","INSERT INTO paises (id,iso,nombre) VALUES(110, 'IS', 'Islandia')","
","INSERT INTO paises (id,iso,nombre) VALUES(111, 'IL', 'Israel')","
","INSERT INTO paises (id,iso,nombre) VALUES(112, 'IT', 'Italia')","
","INSERT INTO paises (id,iso,nombre) VALUES(113, 'JM', 'Jamaica')","
","INSERT INTO paises (id,iso,nombre) VALUES(114, 'JP', 'Japón')","
","INSERT INTO paises (id,iso,nombre) VALUES(115, 'JO', 'Jordania')","
","INSERT INTO paises (id,iso,nombre) VALUES(116, 'KZ', 'Kazajstán')","
","INSERT INTO paises (id,iso,nombre) VALUES(117, 'KE', 'Kenia')","
","INSERT INTO paises (id,iso,nombre) VALUES(118, 'KG', 'Kirguistán')","
","INSERT INTO paises (id,iso,nombre) VALUES(119, 'KI', 'Kiribati')","
","INSERT INTO paises (id,iso,nombre) VALUES(120, 'KW', 'Kuwait')","
","INSERT INTO paises (id,iso,nombre) VALUES(121, 'LA', 'Laos')","
","INSERT INTO paises (id,iso,nombre) VALUES(122, 'LS', 'Lesotho')","
","INSERT INTO paises (id,iso,nombre) VALUES(123, 'LV', 'Letonia')","
","INSERT INTO paises (id,iso,nombre) VALUES(124, 'LB', 'Líbano')","
","INSERT INTO paises (id,iso,nombre) VALUES(125, 'LR', 'Liberia')","
","INSERT INTO paises (id,iso,nombre) VALUES(126, 'LY', 'Libia')","
","INSERT INTO paises (id,iso,nombre) VALUES(127, 'LI', 'Liechtenstein')","
","INSERT INTO paises (id,iso,nombre) VALUES(128, 'LT', 'Lituania')","
","INSERT INTO paises (id,iso,nombre) VALUES(129, 'LU', 'Luxemburgo')","
","INSERT INTO paises (id,iso,nombre) VALUES(130, 'MO', 'Macao')","
","INSERT INTO paises (id,iso,nombre) VALUES(131, 'MK', 'ARY Macedonia')","
","INSERT INTO paises (id,iso,nombre) VALUES(132, 'MG', 'Madagascar')","
","INSERT INTO paises (id,iso,nombre) VALUES(133, 'MY', 'Malasia')","
","INSERT INTO paises (id,iso,nombre) VALUES(134, 'MW', 'Malawi')","
","INSERT INTO paises (id,iso,nombre) VALUES(135, 'MV', 'Maldivas')","
","INSERT INTO paises (id,iso,nombre) VALUES(136, 'ML', 'Malí')","
","INSERT INTO paises (id,iso,nombre) VALUES(137, 'MT', 'Malta')","
","INSERT INTO paises (id,iso,nombre) VALUES(138, 'FK', 'Islas Malvinas')","
","INSERT INTO paises (id,iso,nombre) VALUES(139, 'MP', 'Islas Marianas del Norte')","
","INSERT INTO paises (id,iso,nombre) VALUES(140, 'MA', 'Marruecos')","
","INSERT INTO paises (id,iso,nombre) VALUES(141, 'MH', 'Islas Marshall')","
","INSERT INTO paises (id,iso,nombre) VALUES(142, 'MQ', 'Martinica')","
","INSERT INTO paises (id,iso,nombre) VALUES(143, 'MU', 'Mauricio')","
","INSERT INTO paises (id,iso,nombre) VALUES(144, 'MR', 'Mauritania')","
","INSERT INTO paises (id,iso,nombre) VALUES(145, 'YT', 'Mayotte')","
","INSERT INTO paises (id,iso,nombre) VALUES(146, 'MX', 'México')","
","INSERT INTO paises (id,iso,nombre) VALUES(147, 'FM', 'Micronesia')","
","INSERT INTO paises (id,iso,nombre) VALUES(148, 'MD', 'Moldavia')","
","INSERT INTO paises (id,iso,nombre) VALUES(149, 'MC', 'Mónaco')","
","INSERT INTO paises (id,iso,nombre) VALUES(150, 'MN', 'Mongolia')","
","INSERT INTO paises (id,iso,nombre) VALUES(151, 'MS', 'Montserrat')","
","INSERT INTO paises (id,iso,nombre) VALUES(152, 'MZ', 'Mozambique')","
","INSERT INTO paises (id,iso,nombre) VALUES(153, 'MM', 'Myanmar')","
","INSERT INTO paises (id,iso,nombre) VALUES(154, 'NA', 'Namibia')","
","INSERT INTO paises (id,iso,nombre) VALUES(155, 'NR', 'Nauru')","
","INSERT INTO paises (id,iso,nombre) VALUES(156, 'NP', 'Nepal')","
","INSERT INTO paises (id,iso,nombre) VALUES(157, 'NI', 'Nicaragua')","
","INSERT INTO paises (id,iso,nombre) VALUES(158, 'NE', 'Níger')","
","INSERT INTO paises (id,iso,nombre) VALUES(159, 'NG', 'Nigeria')","
","INSERT INTO paises (id,iso,nombre) VALUES(160, 'NU', 'Niue')","
","INSERT INTO paises (id,iso,nombre) VALUES(161, 'NF', 'Isla Norfolk')","
","INSERT INTO paises (id,iso,nombre) VALUES(162, 'NO', 'Noruega')","
","INSERT INTO paises (id,iso,nombre) VALUES(163, 'NC', 'Nueva Caledonia')","
","INSERT INTO paises (id,iso,nombre) VALUES(164, 'NZ', 'Nueva Zelanda')","
","INSERT INTO paises (id,iso,nombre) VALUES(165, 'OM', 'Omán')","
","INSERT INTO paises (id,iso,nombre) VALUES(166, 'NL', 'Países Bajos')","
","INSERT INTO paises (id,iso,nombre) VALUES(167, 'PK', 'Pakistán')","
","INSERT INTO paises (id,iso,nombre) VALUES(168, 'PW', 'Palau')","
","INSERT INTO paises (id,iso,nombre) VALUES(169, 'PS', 'Palestina')","
","INSERT INTO paises (id,iso,nombre) VALUES(170, 'PA', 'Panamá')","
","INSERT INTO paises (id,iso,nombre) VALUES(171, 'PG', 'Papúa Nueva Guinea')","
","INSERT INTO paises (id,iso,nombre) VALUES(172, 'PY', 'Paraguay')","
","INSERT INTO paises (id,iso,nombre) VALUES(173, 'PE', 'Perú')","
","INSERT INTO paises (id,iso,nombre) VALUES(174, 'PN', 'Islas Pitcairn')","
","INSERT INTO paises (id,iso,nombre) VALUES(175, 'PF', 'Polinesia Francesa')","
","INSERT INTO paises (id,iso,nombre) VALUES(176, 'PL', 'Polonia')","
","INSERT INTO paises (id,iso,nombre) VALUES(177, 'PT', 'Portugal')","
","INSERT INTO paises (id,iso,nombre) VALUES(178, 'PR', 'Puerto Rico')","
","INSERT INTO paises (id,iso,nombre) VALUES(179, 'QA', 'Qatar')","
","INSERT INTO paises (id,iso,nombre) VALUES(180, 'GB', 'Reino Unido')","
","INSERT INTO paises (id,iso,nombre) VALUES(181, 'RE', 'Reunión')","
","INSERT INTO paises (id,iso,nombre) VALUES(182, 'RW', 'Ruanda')","
","INSERT INTO paises (id,iso,nombre) VALUES(183, 'RO', 'Rumania')","
","INSERT INTO paises (id,iso,nombre) VALUES(184, 'RU', 'Rusia')","
","INSERT INTO paises (id,iso,nombre) VALUES(185, 'EH', 'Sahara Occidental')","
","INSERT INTO paises (id,iso,nombre) VALUES(186, 'SB', 'Islas Salomón')","
","INSERT INTO paises (id,iso,nombre) VALUES(187, 'WS', 'Samoa')","
","INSERT INTO paises (id,iso,nombre) VALUES(188, 'AS', 'Samoa Americana')","
","INSERT INTO paises (id,iso,nombre) VALUES(189, 'KN', 'San Cristóbal y Nevis')","
","INSERT INTO paises (id,iso,nombre) VALUES(190, 'SM', 'San Marino')","
","INSERT INTO paises (id,iso,nombre) VALUES(191, 'PM', 'San Pedro y Miquelón')","
","INSERT INTO paises (id,iso,nombre) VALUES(192, 'VC', 'San Vicente y las Granadinas')","
","INSERT INTO paises (id,iso,nombre) VALUES(193, 'SH', 'Santa Helena')","
","INSERT INTO paises (id,iso,nombre) VALUES(194, 'LC', 'Santa Lucía')","
","INSERT INTO paises (id,iso,nombre) VALUES(195, 'ST', 'Santo Tomé y Príncipe')","
","INSERT INTO paises (id,iso,nombre) VALUES(196, 'SN', 'Senegal')","
","INSERT INTO paises (id,iso,nombre) VALUES(197, 'CS', 'Serbia y Montenegro')","
","INSERT INTO paises (id,iso,nombre) VALUES(198, 'SC', 'Seychelles')","
","INSERT INTO paises (id,iso,nombre) VALUES(199, 'SL', 'Sierra Leona')","
","INSERT INTO paises (id,iso,nombre) VALUES(200, 'SG', 'Singapur')","
","INSERT INTO paises (id,iso,nombre) VALUES(201, 'SY', 'Siria')","
","INSERT INTO paises (id,iso,nombre) VALUES(202, 'SO', 'Somalia')","
","INSERT INTO paises (id,iso,nombre) VALUES(203, 'LK', 'Sri Lanka')","
","INSERT INTO paises (id,iso,nombre) VALUES(204, 'SZ', 'Suazilandia')","
","INSERT INTO paises (id,iso,nombre) VALUES(205, 'ZA', 'Sudáfrica')","
","INSERT INTO paises (id,iso,nombre) VALUES(206, 'SD', 'Sudán')","
","INSERT INTO paises (id,iso,nombre) VALUES(207, 'SE', 'Suecia')","
","INSERT INTO paises (id,iso,nombre) VALUES(208, 'CH', 'Suiza')","
","INSERT INTO paises (id,iso,nombre) VALUES(209, 'SR', 'Surinam')","
","INSERT INTO paises (id,iso,nombre) VALUES(210, 'SJ', 'Svalbard y Jan Mayen')","
","INSERT INTO paises (id,iso,nombre) VALUES(211, 'TH', 'Tailandia')","
","INSERT INTO paises (id,iso,nombre) VALUES(212, 'TW', 'Taiwán')","
","INSERT INTO paises (id,iso,nombre) VALUES(213, 'TZ', 'Tanzania')","
","INSERT INTO paises (id,iso,nombre) VALUES(214, 'TJ', 'Tayikistán')","
","INSERT INTO paises (id,iso,nombre) VALUES(215, 'IO', 'Territorio Británico del Océano Índico')","
","INSERT INTO paises (id,iso,nombre) VALUES(216, 'TF', 'Territorios Australes Franceses')","
","INSERT INTO paises (id,iso,nombre) VALUES(217, 'TL', 'Timor Oriental')","
","INSERT INTO paises (id,iso,nombre) VALUES(218, 'TG', 'Togo')","
","INSERT INTO paises (id,iso,nombre) VALUES(219, 'TK', 'Tokelau')","
","INSERT INTO paises (id,iso,nombre) VALUES(220, 'TO', 'Tonga')","
","INSERT INTO paises (id,iso,nombre) VALUES(221, 'TT', 'Trinidad y Tobago')","
","INSERT INTO paises (id,iso,nombre) VALUES(222, 'TN', 'Túnez')","
","INSERT INTO paises (id,iso,nombre) VALUES(223, 'TC', 'Islas Turcas y Caicos')","
","INSERT INTO paises (id,iso,nombre) VALUES(224, 'TM', 'Turkmenistán')","
","INSERT INTO paises (id,iso,nombre) VALUES(225, 'TR', 'Turquía')","
","INSERT INTO paises (id,iso,nombre) VALUES(226, 'TV', 'Tuvalu')","
","INSERT INTO paises (id,iso,nombre) VALUES(227, 'UA', 'Ucrania')","
","INSERT INTO paises (id,iso,nombre) VALUES(228, 'UG', 'Uganda')","
","INSERT INTO paises (id,iso,nombre) VALUES(229, 'UY', 'Uruguay')","
","INSERT INTO paises (id,iso,nombre) VALUES(230, 'UZ', 'Uzbekistán')","
","INSERT INTO paises (id,iso,nombre) VALUES(231, 'VU', 'Vanuatu')","
","INSERT INTO paises (id,iso,nombre) VALUES(232, 'VE', 'Venezuela')","
","INSERT INTO paises (id,iso,nombre) VALUES(233, 'VN', 'Vietnam')","
","INSERT INTO paises (id,iso,nombre) VALUES(234, 'VG', 'Islas Vírgenes Británicas')","
","INSERT INTO paises (id,iso,nombre) VALUES(235, 'VI', 'Islas Vírgenes de los Estados Unidos')","
","INSERT INTO paises (id,iso,nombre) VALUES(236, 'WF', 'Wallis y Futuna')","
","INSERT INTO paises (id,iso,nombre) VALUES(237, 'YE', 'Yemen')","
","INSERT INTO paises (id,iso,nombre) VALUES(238, 'DJ', 'Yibuti')","
","INSERT INTO paises (id,iso,nombre) VALUES(239, 'ZM', 'Zambia')","
","INSERT INTO paises (id,iso,nombre) VALUES(240, 'ZW', 'Zimbabue')"];
foreach ($paises as $key => $value) {
    $x->executeQuery($value);
}
/*
$tabla="CarEgresoSalud";
$x->dropTable("drop table ".$tabla);
$mdl->createTable("create table CarEgresoSalud
(
Salud_Egreso_Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Plan_Medico  	char(2),
Meta_PII     	long,
Informe_Tecnico    	char(2),
Des_Informe  	varchar(200),
Cumple_Plan  	varchar(180),
Enfermedades_Cronicas  char(2),
Especificar  	varchar(200),
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
");*/
 //$mdl->createTable ("Create sequence CarEgresoSaludS");
   /* $mdl->createTable ("drop sequence seq_Carproblematica_familiar");
    */
    //$x->deleteDataNoWhere("pam_nivel_educativo");
    /*
print_r($x->executeQuery("insert into Cardesempeno_academico (id,nombre,fecha_creacion,Usuario_Crea,Usuario_Edita) values(1,'SI, sobresaliente',sysdate,1,1)"));
print_r($x->executeQuery("insert into Cardesempeno_academico (id,nombre,fecha_creacion,Usuario_Crea,Usuario_Edita) values(2,'Si, satisfactorio',sysdate,1,1)"));
print_r($x->executeQuery("insert into Cardesempeno_academico (id,nombre,fecha_creacion,Usuario_Crea,Usuario_Edita) values(3,'NO',sysdate,1,1)"));
print_r($x->executeQuery("insert into Cardesempeno_academico (id,nombre,fecha_creacion,Usuario_Crea,Usuario_Edita) values(4,'No, insatisfactorio',sysdate,1,1)"))
print_r($x->executeQuery("SELECT * FROM CarEgresoPsicologico WHERE RESIDENTE_ID = 1 AND ESTADO=1"));
die();*/
/*
$arr = ['create table CarCentroServicio
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Cod_Entidad char(6),
Nom_Entidad varchar(50),
Cod_Linea  char(6),
Linea_Intervencion varchar(250),
Cod_Servicio 	char(6),
Nom_Servicio 	varchar(200),
Ubigeo_Ine int,
Departamento_CAtencion int,
Provincia_CAtencion int,
Distrito_CAtencion 	int,
Centro_Poblado     	int,
Centro_Residencia  	varchar(10),
Cod_CentroAtencion 	char(6),
Nom_CentroAtencion 	varchar(200),
Fecha_Registro     	date,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)','
create table CarIdentificacionUsuario
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Ape_Paterno varchar2(50),
Ape_Materno varchar2(50),
Nom_Usuario varchar2(50),
Pais_Procencia   int,
Depatamento_Procedencia int,
Provincia_Procedencia  int,
Distrito_Procedencia   int,
Sexo          	char(2),
Fecha_Nacimiento date,
Edad          	int,
Lengua_Materna     	int,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','create table CarDatosAdmision
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Mov_Poblacional varchar(100),
Fecha_Ingreso    date,
Fecha_Reingreso  date,
Institucion_derivado int,
Motivo_Ingreso    varchar(100),
Tipo_Documento   int,
Numero_Documento int,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
create table CarCondicionIngreso
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
DNI   char(2),
Tipo_Documento     	int,
Numero_Documento int,
Lee_Escribe  	char(2),
Nivel_Educativo    	int,
Institucion_Educativa  int,
Tipo_Seguro  	int,
Clasficacion_Socioeconomica int,
Familiares   	char(2),
Parentesco   	int,
Posee_Pension char(2),
Tipo_Pension INT,
Problematica_Familiar int,
 Estado            	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
create table CarSaludNutricion
(
Id int not null primary key ,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Discapacidad       	char(2),
Discapacidad_Fisica	varchar(40),
Discapacidad_Intelectual varchar(40),
Discapacidad_Sensorial varchar(40),
Discapacidad_mental varchar(40),
Certificacdo_Dx    	char(2),
Carnet_CONADIS     	char(20),
Movilidad    	int,
Motivo_Movilidad int,
Dificultad_Movilidad   int,
Patologia1   	char(20),
Tipo_Patologia1    	int,
Especifique1       	varchar(250),
Patologia2   	char(20),
Tipo_Patologia2    	int,
Especifique2       	varchar(200),
Nivel_Hemoglobina  	number(6,2),
Anemia             	char(20),
Peso          	number(6,2),
Talla         	number(6,2),
Estado_Nutricional 	int,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
Create table CarSaludMental
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Transtorno_Neurologico char(20),
Des_Transtorno     	int,
Tipo_Transtorno    	int,
Dificultad_habla varchar(100),
Metodo_comunicarse 	varchar(100),
Comprension  	char(2),
Tipo_Dificultad    	varchar(100),
Actividades_Diarias	int,
Especificar  	long,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
create table CarTerapia
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Num_TMotriz int,
Num_TPsicomotricidad   int,
Num_TFisioterapia  	int,
Num_TDeportes      	int,
Num_TComunicacion  	int,
Num_TOrofacial     	int,
Num_TLenguaje      	int,
Num_TLenguajeA     	int,
Tipo_LenguajeA     	int,
Num_TABVD    	int,
Num_TInstrumentalesB   int,
Num_TInstrumentalesC   int,
Num_TSensoriales int,
Num_TReceptivas    	int,
Num_TOrteticos     	int,
Num_TSoillaR       	int,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
create table CarActividades
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Num_Biohuerto	int,
Num_Manualidades int,
Num_Panaderia      	int,
Num_Paseos   	int,
Num_Culturales     	int,
Num_Civicas  	int,
Num_Futbol   	int,
Num_Natacion       	int,
Num_otrosDe  	int,
Num_ManejoDinero int,
Num_decisiones     	int,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
create table CarAtencionPsicologica
(
Id      	int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Num_HBasicas             	int,
Num_HConceptuales        	int,
Num_HSociales            	int,
Num_HPracticas           	int,
Num_HModificacion        	int,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
create table CarEducacionCapacidades
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Tipo_Institucion varchar(100),
Insertado_labora char(2),
Des_labora   	long,
Participa_Actividades  char(2),
Fecha_InicionA     	date,
Fecha_FinA   	date,
Culmino_Actividades	char(2),
Logro_Actividades  	char(2),
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
 
','
create table CarTrabajoSocial
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Visitas    char(2),
Num_Visitas int,
Reinsercion_Familiar   char(2),
Familia_RedesS     	char(2),
Des_Persona_Visita 	varchar(50),
DNI           	char(2),
AUS           	char(2),
CONADIS            	char(2),
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
 
','
create table CarAtencionSalud
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Num_MedicinaG	int,
Salida_Hospitales char(2),
Num_Cardiovascular 	int,
Num_Nefrologia     	int,
Num_Oncologia      	int,
Num_Neurocirugia int,
Num_Dermatologia int,
Num_Endocrinologia 	int,
Num_Gastroenterologia  int,
Num_Gineco_Obsterica   int,
Num_Hematologia    	int,
Num_Infec_contagiosa   int,
Num_Inmunologia    	int,
Num_Medicina_fisica	int,
Num_Neumologia     	int,
Num_Nutricion      	int,
Num_Neurologia     	int,
Num_Oftalmologia int,
Num_Otorrinolarinlogia int,
Num_Pedriatria     	int,
Num_Psiquiatria    	int,
Num_Quirurgica     	int,
Num_Traumologia    	int,
Num_Urologia       	int,
Num_Odontologia    	int,
Num_Otro     	int,
Tratamiento_Psicofarmaco	char(2),
Hopitalizado_Periodo   char(2),
Numero_Hospitalizaciones int,
MotivoHospitalizacion varchar(250),
NumSalidasHospital int,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int)','
 
create table CarEgresoPsicologico
(
Id int not null primary key ,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Plan_Psicologico char(2),
Meta_PII     	varchar(250),
Informe_Tecnico    	char(2),
Des_Informe  	varchar(200),
Cumple_Plan  	varchar(180),
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
 
','
 
create table CarEgresoEducacion
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Plan_Educacion     	char(2),
Meta_PII     	varchar(250),
Informe_Tecnico    	char(2),
Des_Informe  	varchar(200),
Cumple_Plan  	varchar(180),
Asistencia_Escolar 	char(2),
Desempeno    	int,
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
create table CarEgresoSalud
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Plan_Medico  	char(2),
Meta_PII     	long,
Informe_Tecnico    	char(2),
Des_Informe  	varchar(200),
Cumple_Plan  	varchar(180),
Enfermedades_Cronicas  char(2),
Especificar  	varchar(250),
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
create table CarTerapiaFisica
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Plan_Medico  	char(2),
Meta_PII     	varchar(250),
Informe_Tecnico    	char(2),
Des_Informe  	varchar(200),
Cumple_Plan  	varchar(180),
Desarrollo_Lenguaje	varchar(250),
Mejora_Fonema      	char(2),
Mejora_Comprensivo 	char(2),
Elabora_Oraciones  	char(2),
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
create table CarEgresoNutricion
(
Id 	int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Plan_Nutricional char(2),
Meta_PII     	varchar(250),
Informe_Tecnico    	char(2),
Des_Informe  	varchar(200),
Cumple_Plan  	varchar(180),
Estado_Nutricional 	varchar(180),
Peso          	number(6,2),
Talla         	number(6,2),
Hemoglobina  	number(6,2),
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
create table CarEgresoTrabajoSocial
(
Id int not null primary key,
Tipo_Centro_Id  int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Plan_Social  	char(2),
Meta_PII     	varchar(250),
Informe_Tecnico    	char(2),
Des_Informe  	varchar(200),
Cumple_Plan  	varchar(180),
Ubicacion_Familia  	char(2),
Participacion_Familia  char(2),
Reinsercion  	char(2),
Colocacion_Laboral 	char(2),
Estado             	int,
Fecha_Creacion     	TIMESTAMP DEFAULT SYSDATE,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
 
Create table CarEgresoGeneral
(
Id  	int not null primary key,
Tipo_Centro_Id     	int,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Fecha_Egreso       	date,
Motivo_Egreso      	varchar(200) null,
Retiro_Voluntario  	varchar(180) null,
Reinsercion_Familiar varchar(180) null,
Grado_Parentesco varchar(180) null,
Traslado	varchar(100) null,
Fallecimiento varchar(100) null,
Restitucion_Derechos char(2) null,
Aus char(2) null,
Constancia_Naci    	char(2),
Carner_CONADIS     	char(2),
DNI           	char(2),
Restitucion_Familiar  	varchar(180),
Estado             	int default 1,
Fecha_Creacion     	date,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
Create table Carproblematica_familiar(
Id int not null primary key,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Nombre varchar(250),
Estado             	int default 1,
Fecha_Creacion     	date,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)
','
Create table Cardesempeno_academico
 (
Id int not null primary key,
Residente_Id	int,
Periodo_Mes int,
Periodo_Anio   int,
Nombre varchar(250),
Estado             	int default 1,
Fecha_Creacion     	date,
Fecha_Edicion      	TIMESTAMP DEFAULT SYSDATE,
Usuario_Crea       	int,
Usuario_Edita      	int
)'];
$arrdrop = ['drop table CarCentroServicio','
drop table CarIdentificacionUsuario','drop table CarDatosAdmision
','
 
drop table CarCondicionIngreso
','
drop table CarSaludNutricion
','
 
drop table CarSaludMental
','
 
drop table CarTerapia
','
 
drop table CarActividades
','
 
drop table CarAtencionPsicologica
','
 
drop table CarEducacionCapacidades
 
','
drop table CarTrabajoSocial
 
','
drop table CarAtencionSalud
 
','
 
drop table CarEgresoPsicologico
 
','
 
drop table CarEgresoEducacion
','
 
drop table CarEgresoSalud
','
 
drop table CarTerapiaFisica
','
 
drop table CarEgresoNutricion
','
 
drop table CarEgresoTrabajoSocial
','
 
drop table CarEgresoGeneral
','
drop table Carproblematica_familiar
','
drop table Cardesempeno_academico'];
$arrdropseq = ['drop sequence seq_CarCentroServicio','
drop sequence seq_CarIdentificacionUsuario','drop sequence seq_CarDatosAdmision
','
 
drop sequence seq_CarCondicionIngreso
','
drop sequence seq_CarSaludNutricion
','
 
drop sequence seq_CarSaludMental
','
 
drop sequence seq_CarTerapia
','
 
drop sequence seq_CarActividades
','
 
drop sequence seq_CarAtencionPsicologica
','
 
drop sequence seq_CarEducacionCapacidades
 
','
drop sequence seq_CarTrabajoSocial
 
','
drop sequence seq_CarAtencionSalud
 
','
 
drop sequence seq_CarEgresoPsicologico
 
','
 
drop sequence seq_CarEgresoEducacion
','
 
drop sequence seq_CarEgresoSalud
','
 
drop sequence seq_CarTerapiaFisica
','
 
drop sequence seq_CarEgresoNutricion
','
 
drop sequence seq_CarEgresoTrabajoSocial
','
 
drop sequence seq_CarEgresoGeneral
','
drop sequence seq_Carproblematica_familiar
','
drop sequence seq_Cardesempeno_academico'];
$arrcreateseq = ['create sequence seq_CarCentroServicio','
create sequence seq_CarIdentificacionUsuario','create sequence seq_CarDatosAdmision
','
 
create sequence seq_CarCondicionIngreso
','
create sequence seq_CarSaludNutricion
','
 
create sequence seq_CarSaludMental
','
 
create sequence seq_CarTerapia
','
 
create sequence seq_CarActividades
','
 
create sequence seq_CarAtencionPsicologica
','
 
create sequence seq_CarEducacionCapacidades
 
','
create sequence seq_CarTrabajoSocial
 
','
create sequence seq_CarAtencionSalud
 
','
 
create sequence seq_CarEgresoPsicologico
 
','
 
create sequence seq_CarEgresoEducacion
','
 
create sequence seq_CarEgresoSalud
','
 
create sequence seq_CarTerapiaFisica
','
 
create sequence seq_CarEgresoNutricion
','
 
create sequence seq_CarEgresoTrabajoSocial
','
 
create sequence seq_CarEgresoGeneral
','
create sequence seq_Carproblematica_familiar
','
create sequence seq_Cardesempeno_academico'];
foreach ($arr as $key => $value) {
    echo $key;
    $x->dropTable($arrdrop[$key]);
    $mdl->createTable($arrdropseq[$key]);
    $mdl->createTable($value);
    $mdl->createTable($arrcreateseq[$key]);
}*/
/*
print_r($x->executeQuery("delete from modulos"));
$arr = ["insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(1,1,1,0,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','ACOGIDA',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(2,1,1,1,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DIAGNÓSTICO',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(3,1,1,2,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DATOS DEL CENTRO DE SERVICIOS',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(4,1,1,2,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DATOS DE IDENTIFICACIÓN DEL USUARIO',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(5,1,1,2,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DATOS DE ADMISIÓN DEL USUARIO',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(6,1,1,2,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DATOS DE CONDICIONES DE INGRESO DEL USUARIO',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(7,1,1,2,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DATOS DE SALUD Y NUTRICIÓN DEL USUARIO',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(8,1,1,2,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','SALUD MENTAL',0,1,'18-DEC-28',1,1)",

"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(9,1,1,0,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','DESARROLLO O CONVIVENCIA',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(10,1,1,9,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','SEGUIMIENTO (MENSUAL)',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(11,1,1,10,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','TERAPIA',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(12,1,1,10,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Actividades Técnico - Productivas',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(13,1,1,10,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Atención Psicológica',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(14,1,1,10,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','FORTALECIMIENTO DE CAPACIDADES',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(15,1,1,10,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Atención en Trabajo Social ',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(16,1,1,10,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Atenciones en Salud',0,1,'18-DEC-28',1,1)",

"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(17,1,1,9,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','SEGUIMIENTO (SEMESTRAL)',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(18,1,1,17,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Psicológico',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(19,1,1,17,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Educación',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(20,1,1,17,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Salud',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(21,1,1,17,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Terapia Física',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(22,1,1,17,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Nutrición',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(23,1,1,17,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Trabajo Social ',0,1,'18-DEC-28',1,1)",

"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(24,1,1,0,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','EGRESO',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(25,1,1,24,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','SALIDA',0,1,'18-DEC-28',1,1)",
"insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)
values(26,1,1,25,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','Datos Generales',0,1,'18-DEC-28',1,1)"];
foreach ($arr as $key => $value) {
    $x->executeQuery($value);
}*/
/*
$x->executeQuery("insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion) 
values(1,1,1,1,'ppd-datos-actividades-tecnico-productivas','fa fa-laptop','ACOGIDA',1,1,SYSDATE,1,1)");*/
/*$x->insertData('modulos', array("id"=>1,"centro_id"=>1,"encargado_id"=>1,"parent_id"=>1,"url_template"=>'ppd-datos-actividades',"icon"=>'fa fa-laptop',"nombre"=>'ACOGIDA',"estado_completo"=>0,"estado"=>1,"fecha_creacion"=>'18-DEC-28',"usuario_creacion"=>1,"usuario_edicion"=>1));*/
print_r($x->executeQuery("select * from modulos"));
/*$x->executeQuery("drop table modulos");
$x->executeQuery("drop SEQUENCE seq_modulos");
$x->executeQuery("create table modulos (
    id INT NOT NULL primary key,
    centro_id INT NOT NULL,
    encargado_id INT NOT NULL,
  parent_id int not null,
  url_template varchar(250),
  icon varchar(100),
    nombre VARCHAR(100) NOT NULL,
    estado_completo INT NULL,
    estado INT DEFAULT 1,
    fecha_creacion date NOT NULL,
    fecha_edicion TIMESTAMP DEFAULT SYSDATE,
    usuario_creacion INT NOT NULL,
    usuario_edicion INT NOT NULL
    )");
$x->executeQuery("DESCRIBE modulos"); 
$x->executeQuery("insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion) values(1,1,1,1,'ppd-datos-actividades','fa fa-laptop','ACOGIDA',1,1,SYSDATE,1,1);");
print_r($x->executeQuery("select * from modulos"));
/*
print_r($x->executeQuery("insert into modulos (id,centro_id,encargado_id,parent_id,url_template,icon,nombre,estado_completo, estado,fecha_creacion,usuario_creacion,usuario_edicion)values(1,1,1,0,'ppd-datos-actividades','fa fa-laptop','ACOGIDA',0,1,SYSDATE,1,1);"));
print_r($x->executeQuery("select * from modulos"));*/

//$x->executeQuery("alter table caratencionsalud add (NumSalidasHospital int)");
//$x->executeQuery("alter table caratencionsalud add (MotivoHospitalizacion varchar(250))");

}
 ?>

<div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="#">
                        <img class="align-content" src="<?php echo IMAGES?>/logo.png" alt="">
                    </a>
                </div>
                <div class="login-form">
                    <form class="" action="<?php $this->url('index') ?>" method="post">
                        <div class="form-group">
                            <label>Usuario</label>
                            <input type="text" class="form-control" name="usuario" placeholder="Ingrese su usuario">
                        </div>
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input type="password" class="form-control" name="contrasena" placeholder="Ingrese su clave">
                        </div>

                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Entrar</button>


                    </form>
                </div>
            </div>
        </div>
    </div>
