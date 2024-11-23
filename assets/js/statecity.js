function GetStateCities() {
  var SelectedState = document.getElementById("SelectedState").value;
  var ShowCityOptions = document.getElementById("ShowCityOptions");

  let cities = {
    "Andaman and Nicobar Islands": [
      "Port Blair",
      "Havelock Island",
      "Neil Island",
      "Diglipur",
      "Mayabunder",
      "Rangat",
      "Little Andaman",
      "Car Nicobar",
      "Campbell Bay",
      "South Andaman",
      "North Andaman",
      "Middle Andaman",
    ],
    "Andhra Pradesh": [
      "Visakhapatnam",
      "Vijayawada",
      "Tirupati",
      "Guntur",
      "Nellore",
      "Kakinada",
      "Rajahmundry",
      "Kurnool",
      "Anantapur",
      "Chittoor",
      "Amalapuram",
      "Bhimavaram",
      "Chirala",
      "Dharmavaram",
      "Eluru",
      "Gudivada",
      "Hindupur",
      "Kadapa",
      "Kavali",
      "Machilipatnam",
      "Narasaraopet",
      "Nandyal",
      "Narasapuram",
      "Ongole",
      "Proddatur",
      "Srikakulam",
      "Tenali",
      "Tadepalligudem",
      "Tadipatri",
      "Vizianagaram",
      "Yemmiganur",
    ],
    "Arunachal Pradesh": [
      "Itanagar",
      "Tawang",
      "Ziro",
      "Bomdila",
      "Namdapha",
      "Pasighat",
      "Roing",
      "Tezu",
      "Daporijo",
      "Along",
      "Anini",
      "Changlang",
      "Khonsa",
      "Naharlagun",
      "Yingkiong",
      "Mechuka",
      "Aalo",
      "Miao",
      "Bhalukpong",
      "Tuting",
    ],
    Assam: [
      "Guwahati",
      "Kaziranga",
      "Jorhat",
      "Tezpur",
      "Silchar",
      "Dibrugarh",
      "Nagaon",
      "Tinsukia",
      "Sivasagar",
      "Goalpara",
      "Barpeta",
      "Dhubri",
      "Hailakandi",
      "Karimganj",
      "Lakhimpur",
      "Majuli",
      "Nalbari",
      "North Lakhimpur",
      "Rangia",
      "Sonitpur",
    ],
    Bihar: [
      "Patna",
      "Gaya",
      "Bodh Gaya",
      "Nalanda",
      "Rajgir",
      "Vaishali",
      "Munger",
      "Darbhanga",
      "Muzaffarpur",
      "Bhagalpur",
      "Arrah",
      "Begusarai",
      "Chapra",
      "Katihar",
      "Purnia",
      "Sasaram",
      "Sitamarhi",
      "Bettiah",
      "Motihari",
      "Jamalpur",
      "Dehri",
      "Aurangabad",
      "Buxar",
      "Madhubani",
      "Samastipur",
      "Siwan",
      "Bihar Sharif",
      "Kishanganj",
      "Hajipur",
      "Jehanabad",
    ],
    Chandigarh: ["Chandigarh"],
    Chhattisgarh: [
      "Raipur",
      "Bhilai",
      "Bilaspur",
      "Durg",
      "Raigarh",
      "Korba",
      "Jagdalpur",
      "Ambikapur",
      "Rajnandgaon",
      "Kawardha",
      "Chirmiri",
      "Janjgir",
      "Dhamtari",
      "Mahasamund",
      "Bhatapara",
      "Kanker",
      "Dalli-Rajhara",
      "Baloda Bazar",
      "Tilda Newra",
      "Balod",
    ],
    "Dadra and Nagar Haveli and Daman and Diu": [
      "Daman",
      "Diu",
      "Silvassa",
      "Nani Daman",
      "Moti Daman",
      "Diu Island",
      "Dadra",
      "Khanvel",
      "Rakholi",
      "Umarkui",
    ],
    Delhi: [
      "New Delhi",
      "Old Delhi",
      "Dwarka",
      "Rohini",
      "Pitampura",
      "Connaught Place",
      "Chanakyapuri",
      "Karol Bagh",
      "South Delhi",
      "East Delhi",
      "West Delhi",
      "North Delhi",
      "Laxmi Nagar",
      "Mayur Vihar",
    ],
    Goa: [
      "Panaji",
      "Vasco da Gama",
      "Margao",
      "Mapusa",
      "Ponda",
      "Calangute",
      "Baga",
      "Anjuna",
      "Colva",
      "Candolim",
      "Old Goa",
      "Dona Paula",
      "Salcete",
      "Sanguem",
      "Curchorem",
    ],
    Gujarat: [
      "Ahmedabad",
      "Surat",
      "Vadodara",
      "Rajkot",
      "Bhavnagar",
      "Jamnagar",
      "Junagadh",
      "Gandhinagar",
      "Anand",
      "Bharuch",
      "Nadiad",
      "Navsari",
      "Morbi",
      "Surendranagar",
      "Gandhidham",
      "Valsad",
      "Veraval",
      "Porbandar",
      "Godhra",
      "Palanpur",
      "Ankleshwar",
      "Dahod",
      "Botad",
      "Mehsana",
      "Vapi",
      "Amreli",
      "Bhuj",
      "Patan",
      "Rajpipla",
      "Vyara",
    ],
    Haryana: [
      "Gurgaon",
      "Faridabad",
      "Panipat",
      "Ambala",
      "Karnal",
      "Hisar",
      "Rohtak",
      "Sonipat",
      "Yamunanagar",
      "Panchkula",
      "Bhiwani",
      "Sirsa",
      "Jind",
      "Rewari",
      "Kaithal",
      "Palwal",
      "Charkhi Dadri",
      "Bahadurgarh",
      "Narnaul",
      "Fatehabad",
      "Hansi",
      "Tohana",
      "Narwana",
      "Safidon",
      "Kurukshetra",
      "Jagadhri",
      "Thanesar",
      "Nuh",
      "Hodal",
      "Ellenabad",
      "Shahabad",
      "Bilaspur",
      "Barwala",
      "Tosham",
      "Kosli",
      "Gohana",
      "Ratia",
      "Fatehabad",
      "Pehowa",
      "Guhla",
    ],
    "Himachal Pradesh": [
      "Shimla",
      "Manali",
      "Dharamshala",
      "Kullu",
      "Chamba",
      "Mandi",
      "Solan",
      "Palampur",
      "Nahan",
      "Dalhousie",
      "Kangra",
      "Una",
      "Bilaspur",
      "Hamirpur",
      "Sirmaur",
      "Kinnaur",
      "Lahaul and Spiti",
      "Kaza",
      "Keylong",
      "Reckong Peo",
      "Chitkul",
      "Kalpa",
      "Rampur",
      "Sangla",
      "Jogindernagar",
      "Chail",
      "Kasauli",
      "Parwanoo",
      "Baddi",
      "Nalagarh",
    ],
    "Jammu and Kashmir": [
      "Srinagar",
      "Jammu",
      "Gulmarg",
      "Leh",
      "Pahalgam",
      "Katra",
      "Sonamarg",
      "Kargil",
      "Udhampur",
      "Baramulla",
      "Anantnag",
      "Bandipora",
      "Doda",
      "Kishtwar",
      "Pulwama",
      "Rajouri",
      "Ramban",
      "Sopore",
      "Handwara",
      "Kupwara",
      "Shopian",
      "Bhaderwah",
      "Ganderbal",
      "Reasi",
      "Tral",
    ],
    Jharkhand: [
      "Ranchi",
      "Jamshedpur",
      "Dhanbad",
      "Bokaro",
      "Hazaribagh",
      "Deoghar",
      "Giridih",
      "Ramgarh",
      "Dumka",
      "Chaibasa",
      "Gumla",
      "Palamu",
      "Lohardaga",
      "Sahibganj",
      "Godda",
      "Chatra",
      "Latehar",
      "Simdega",
      "Khunti",
      "Garhwa",
    ],
    Karnataka: [
      "Bangalore",
      "Mysore",
      "Hubli",
      "Mangalore",
      "Belgaum",
      "Udupi",
      "Gulbarga",
      "Davanagere",
      "Bellary",
      "Shimoga",
      "Hassan",
      "Bidar",
      "Chitradurga",
      "Hospet",
      "Raichur",
      "Chikmagalur",
      "Bagalkot",
      "Karwar",
      "Kolar",
      "Ramanagara",
      "Tumkur",
      "Chikkaballapur",
      "Madikeri",
      "Chikkamagaluru",
      "Mandya",
      "Haveri",
      "Dharwad",
      "Gadag",
      "Koppal",
      "Sirsi",
    ],
    Kerala: [
      "Thiruvananthapuram",
      "Kochi",
      "Kozhikode",
      "Thrissur",
      "Palakkad",
      "Kollam",
      "Alappuzha",
      "Kottayam",
      "Kannur",
      "Kasaragod",
      "Malappuram",
      "Pathanamthitta",
      "Idukki",
      "Wayanad",
      "Ernakulam",
      "Ponnani",
      "Thalassery",
      "Mattannur",
      "Perinthalmanna",
      "Manjeri",
      "Koyilandy",
      "Neyyattinkara",
      "Adoor",
      "Changanassery",
      "Pala",
    ],
    Ladakh: [
      "Leh",
      "Kargil",
      "Nubra Valley",
      "Pangong Tso",
      "Zanskar",
      "Tso Moriri",
      "Hemis",
      "Diskit",
      "Lamayuru",
      "Alchi",
      "Thiksey",
      "Shey",
      "Stok",
      "Phyang",
      "Likir",
      "Sarchu",
      "Chang La",
      "Hanle",
      "Tsomoriri Lake",
      "Pang",
      "Nyoma",
      "Chumathang",
      "Dah Hanu",
      "Turtuk",
      "Sumur",
    ],
    Lakshadweep: [
      "Kavaratti",
      "Agatti",
      "Andrott",
      "Minicoy",
      "Kalpeni",
      "Kadmat",
      "Amini",
      "Chetlat",
      "Bitra",
      "Kiltan",
      "Bangaram",
      "Thinnakara",
      "Pitti",
      "Suheli Par",
      "Parali 1",
      "Parali 2",
      "Parali 3",
      "Kalpeni",
      "Cheriyam",
      "Perumal Par",
    ],
    "Madhya Pradesh": [
      "Bhopal",
      "Indore",
      "Jabalpur",
      "Gwalior",
      "Ujjain",
      "Sagar",
      "Rewa",
      "Satna",
      "Damoh",
      "Chhindwara",
      "Ratlam",
      "Khajuraho",
      "Mandsaur",
      "Neemuch",
      "Dewas",
      "Hoshangabad",
      "Vidisha",
      "Seoni",
      "Shivpuri",
      "Burhanpur",
      "Pithampur",
      "Betul",
      "Itarsi",
      "Khandwa",
      "Chhatarpur",
      "Guna",
      "Datia",
      "Raisen",
      "Morena",
      "Harda",
      "Singrauli",
      "Balaghat",
      "Shajapur",
      "Dhar",
      "Narsinghpur",
      "Sehore",
      "Katni",
      "Damoh",
      "Sidhi",
      "Chitrakoot",
    ],
    Maharashtra: [
      "Mumbai",
      "Pune",
      "Nagpur",
      "Nashik",
      "Aurangabad",
      "Solapur",
      "Kolhapur",
      "Amravati",
      "Navi Mumbai",
      "Thane",
      "Akola",
      "Bhiwandi",
      "Chandrapur",
      "Dombivli",
      "Jalgaon",
      "Latur",
      "Malegaon",
      "Panvel",
      "Sangli",
      "Satara",
      "Vasai-Virar",
      "Wardha",
      "Yavatmal",
      "Ahmednagar",
      "Dhule",
      "Ichalkaranji",
      "Parbhani",
      "Ulhasnagar",
      "Palghar",
      "Beed",
    ],
    Manipur: [
      "Imphal",
      "Ukhrul",
      "Chandel",
      "Senapati",
      "Thoubal",
      "Bishnupur",
      "Tamenglong",
      "Kakching",
      "Jiribam",
      "Churachandpur",
      "Moirang",
      "Moreh",
      "Nungba",
      "Kangpokpi",
      "Lilong",
      "Khongjom",
      "Yaingangpokpi",
      "Noney",
      "Phungyar",
      "Lamshang",
    ],
    Meghalaya: [
      "Shillong",
      "Cherrapunji",
      "Tura",
      "Jowai",
      "Williamnagar",
      "Baghmara",
      "Nongpoh",
      "Resubelpara",
      "Khliehriat",
      "Mairang",
      "Dawki",
      "Nongstoin",
      "Amlarem",
      "Ampati",
      "Mahendraganj",
      "Ranikor",
      "Sohra",
      "Mawkyrwat",
      "Umiam",
      "Khatarshnong",
    ],
    Mizoram: [
      "Aizawl",
      "Lunglei",
      "Champhai",
      "Serchhip",
      "Kolasib",
      "Lawngtlai",
      "Saiha",
      "Khawzawl",
      "Hnahthial",
      "Demagiri",
      "Mamit",
      "Thenzawl",
      "Saitual",
      "Biate",
      "Sialsuk",
      "Khawbung",
      "Tlabung",
      "Zawlnuam",
      "Vairengte",
      "Thingsulthliah",
      "Sawhmual",
      "N.Vanlaiphai",
      "N.Vanlaiphai",
      "Neihdawn",
      "Lengpui",
    ],
    Nagaland: [
      "Kohima",
      "Dimapur",
      "Mokokchung",
      "Wokha",
      "Tuensang",
      "Zunheboto",
      "Phek",
      "Mon",
      "Longleng",
      "Kiphire",
      "Peren",
      "Chumukedima",
      "Pfütsero",
      "Chuchuyimlang",
      "Tizit",
      "Meluri",
      "Alichen",
      "Shamator",
      "Tuli",
      "Tseminyu",
      "Kohima Town",
      "Diphupar",
      "Medziphema",
      "Zubza",
      "Naginimora",
      "Chizami",
      "Khonoma",
      "Kiphire",
      "Longchem",
      "Mangkolemba",
    ],
    Odisha: [
      "Bhubaneswar",
      "Cuttack",
      "Puri",
      "Konark",
      "Rourkela",
      "Sambalpur",
      "Berhampur",
      "Balasore",
      "Bargarh",
      "Jharsuguda",
      "Baripada",
      "Brahmapur",
      "Jagatsinghpur",
      "Jajpur",
      "Kendrapara",
      "Malkangiri",
      "Nabarangpur",
      "Phulbani",
      "Rayagada",
      "Bhadrak",
      "Paradeep",
      "Angul",
      "Dhenkanal",
      "Bolangir",
      "Jeypore",
      "Keonjhar",
      "Sundargarh",
      "Sonepur",
      "Rajgangpur",
      "Titlagarh",
    ],
    Puducherry: [
      "Puducherry",
      "Karaikal",
      "Mahe",
      "Yanam",
      "Auroville",
      "Ozhukarai",
      "Villianur",
      "Bahour",
      "Nedungadu",
      "Manavely",
      "Muthialpet",
      "Lawspet",
      "Reddiarpalayam",
      "Mudaliarpet",
      "Thavalakuppam",
      "Nellithope",
      "Kalapet",
      "Murungapakkam",
      "Mudaliarpet",
      "Nettapakkam",
    ],
    Punjab: [
      "Chandigarh",
      "Amritsar",
      "Ludhiana",
      "Jalandhar",
      "Patiala",
      "Bathinda",
      "Mohali",
      "Pathankot",
      "Moga",
      "Firozpur",
      "Hoshiarpur",
      "Batala",
      "Khanna",
      "Sangrur",
      "Abohar",
      "Faridkot",
      "Muktsar",
      "Gurdaspur",
      "Malout",
      "Nabha",
      "Rajpura",
      "Kapurthala",
      "Sunam",
      "Barnala",
      "Fatehgarh Sahib",
      "Ropar",
      "Fazilka",
      "Zirakpur",
      "Gobindgarh",
      "Dera Baba Nanak",
    ],
    Rajasthan: [
      "Jaipur",
      "Udaipur",
      "Jodhpur",
      "Ajmer",
      "Pushkar",
      "Bikaner",
      "Kota",
      "Mount Abu",
      "Alwar",
      "Sikar",
      "Chittorgarh",
      "Bhilwara",
      "Barmer",
      "Sawai Madhopur",
      "Hanumangarh",
      "Pali",
      "Tonk",
      "Bharatpur",
      "Dungarpur",
      "Jaisalmer",
      "Nagaur",
      "Churu",
      "Jhunjhunu",
      "Banswara",
      "Sirohi",
    ],
    Sikkim: [
      "Gangtok",
      "Namchi",
      "Pelling",
      "Lachung",
      "Lachen",
      "Yuksom",
      "Ravangla",
      "Gyalshing",
      "Mangan",
      "Singtam",
      "Rinchenpong",
      "Chungthang",
      "Rangpo",
      "Rongli",
      "Soreng",
      "Dzongu",
      "Kabi",
      "Kewzing",
      "Legship",
      "Martam",
    ],
    "Tamil Nadu": [
      "Chennai",
      "Coimbatore",
      "Madurai",
      "Tiruchirappalli",
      "Salem",
      "Vellore",
      "Tirunelveli",
      "Thanjavur",
      "Kanchipuram",
      "Erode",
      "Thoothukudi",
      "Tiruppur",
      "Namakkal",
      "Karur",
      "Nagercoil",
      "Dindigul",
      "Cuddalore",
      "Kanyakumari",
      "Hosur",
      "Pollachi",
    ],
    Telangana: [
      "Hyderabad",
      "Warangal",
      "Nizamabad",
      "Karimnagar",
      "Khammam",
      "Ramagundam",
      "Mahabubnagar",
      "Nalgonda",
      "Adilabad",
      "Suryapet",
      "Miryalaguda",
      "Jagtial",
      "Siddipet",
      "Medak",
      "Mancherial",
      "Nirmal",
      "Kothagudem",
      "Bhongir",
      "Sangareddy",
      "Vikarabad",
      "Yadadri",
      "Peddapalli",
      "Wanaparthy",
      "Nagarkurnool",
      "Jangaon",
    ],
    Tripura: [
      "Agartala",
      "Udaipur",
      "Ambassa",
      "Dharmanagar",
      "Kailashahar",
      "Belonia",
      "Khowai",
      "Sonamura",
      "Kamalpur",
      "Mohanpur",
      "Sabroom",
      "Amarpur",
      "Jogendranagar",
      "Teliamura",
      "Kanchanpur",
      "Amarpur",
      "Bishalgarh",
      "Champahawar",
      "Gakulnagar",
      "Jolaibari",
    ],
    "Uttar Pradesh": [
      "Lucknow",
      "Kanpur",
      "Varanasi",
      "Agra",
      "Allahabad",
      "Ghaziabad",
      "Noida",
      "Meerut",
      "Bareilly",
      "Aligarh",
      "Moradabad",
      "Saharanpur",
      "Gorakhpur",
      "Faizabad",
      "Jhansi",
      "Muzaffarnagar",
      "Mathura",
      "Rampur",
      "Shahjahanpur",
      "Firozabad",
      "Ayodhya",
      "Etawah",
      "Basti",
      "Sultanpur",
      "Barabanki",
      "Hapur",
      "Deoria",
      "Ballia",
      "Lakhimpur",
      "Banda",
      "Modinagar",
      "Amroha",
      "Raebareli",
      "Sitapur",
      "Bahraich",
      "Unnao",
      "Jaunpur",
      "Mirzapur",
      "Fatehpur",
      "Hardoi",
      "Gonda",
      "Orai",
      "Azamgarh",
      "Ghazipur",
      "Shamli",
      "Bijnor",
      "Pilibhit",
      "Hathras",
      "Sambhal",
      "Mau",
      "Jalaun",
      "Pratapgarh",
      "Bulandshahr",
      "Etah",
      "Mainpuri",
      "Shahjahanpur",
      "Amethi",
      "Farrukhabad",
      "Kasganj",
      "Mahoba",
    ],
    Uttarakhand: [
      "Dehradun",
      "Haridwar",
      "Rishikesh",
      "Mussoorie",
      "Nainital",
      "Almora",
      "Auli",
      "Chamoli",
      "Pithoragarh",
      "Ranikhet",
      "Bageshwar",
      "Uttarkashi",
      "Haldwani",
      "Kathgodam",
      "Pauri",
      "Tehri",
      "Roorkee",
      "Joshimath",
      "Gopeshwar",
      "Champawat",
      "Mukteshwar",
      "Ramnagar",
      "Lansdowne",
      "Chakrata",
      "Jageshwar",
    ],
    "West Bengal": [
      "Kolkata",
      "Darjeeling",
      "Siliguri",
      "Durgapur",
      "Howrah",
      "Asansol",
      "Malda",
      "Baharampur",
      "Haldia",
      "Kharagpur",
      "Bardhaman",
      "Murshidabad",
      "Raiganj",
      "Medinipur",
      "Cooch Behar",
      "Jalpaiguri",
      "Balurghat",
      "Krishnanagar",
      "Bankura",
      "Alipurduar",
      "Purulia",
      "Bishnupur",
      "Chandannagar",
      "Nabadwip",
      "Basirhat",
      "Suri",
      "Tamluk",
      "Habra",
      "Kolkata Metropolitan Area",
      "Ranaghat",
      "Barasat",
      "Kalyani",
      "Uluberia",
      "Naihati",
      "Bongaon",
      "Barrackpore",
      "Diamond Harbour",
      "Raghunathpur",
      "Arambagh",
      "Jangipur",
      "Bhatpara",
      "Beldanga",
      "Chinsurah",
      "Contai",
      "Dum Dum",
      "Hugli-Chinsurah",
      "Islampur",
      "Katwa",
      "Konnagar",
      "Memari",
      "Raghunathganj",
      "Sainthia",
      "Santipur",
      "Sonamukhi",
      "Srirampore",
      "Titagarh",
      "Bansberia",
      "Bidhan Nagar",
      "Bolpur",
      "English Bazar",
      "Garulia",
      "Ghatal",
      "Guskara",
      "Halisahar",
      "Jhalda",
      "Jhalida",
      "Kalimpong",
      "Kamarhati",
      "Kandi",
      "Kharar",
      "Muragachha",
      "Nabadwip",
      "Nalhati",
      "Panchla",
      "Pandua",
      "Panihati",
      "Ranaghat",
      "Serampore",
      "Taki",
      "Tarakeswar",
      "Uttarpara Kotrung",
      "Maheshtala",
      "Rajpur Sonarpur",
      "South Dum Dum",
      "Madhyamgram",
    ],
  };

  // Clear previous city options
  ShowCityOptions.innerHTML = "";

  // Populate city options based on selected state
  cities[SelectedState].forEach(function (city) {
    var option = document.createElement("option");
    option.text = city;
    ShowCityOptions.add(option);
  });
}
