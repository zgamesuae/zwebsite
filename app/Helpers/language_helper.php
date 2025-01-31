
<?php


if(!function_exists("lg_get_text")){

function lg_get_text($txt_code){
    $lg_code = get_cookie("language");
    $lg_texts = array(
        "EN" => array(
            "lg_01" => "ZGames",
            "lg_02" => "Information",
            "lg_03" => "About us",
            "lg_04" => "Contact us",
            "lg_05" => "Terms &amp; Conditions",
            "lg_06" => "Privacy Policy",
            "lg_07" => "FAQ",
            "lg_08" => "Delivery information",
            "lg_09" => "Refund Policy",
            "lg_10" => "Our stores",
            "lg_11" => "Categories",
            "lg_12" => "Follow us",
            "lg_13" => "Location",
            "lg_14" => "We accept the following payment methods",
            "lg_15" => "Subscribe To Our Newsletter",
            "lg_16" => "Subscribe",
            "lg_17" => "Email Address",
            "lg_18" => "SHOP BY BRAND",
            "lg_19" => "MORE IN ACCESSORIES",
            "lg_20" => "MORE IN GAMES",
            "lg_21" => "SHOP GAMES BY GENRE",
            "lg_22" => "COMING SOON",
            "lg_23" => "NEW IN ACCESSORIES",
            "lg_24" => "PLAYSTATION",
            "lg_25" => "XBOX",
            "lg_26" => "BEST OFFERS",
            "lg_27" => "SHOP BY CATEGORY",
            "lg_28" => "Games",
            "lg_29" => "CONSOLES",
            "lg_30" => "HEADSETS",
            "lg_31" => "CONTROLLERS",
            "lg_32" => "View All",
            "lg_33" => "Add To Cart",
            "lg_34" => "Pre-orders",
            "lg_35" => "Square enix",
            "lg_36" => "New Releases",
            "lg_37" => "Electronic Arts",
            "lg_38" => "Best deals",
            "lg_39" => "Capcom",
            "lg_40" => "Ubisoft",
            "lg_41" => "Bandai",
            "lg_42" => "Playstation 5",
            "lg_43" => "Xbox One",
            "lg_44" => "Xbox Series S",
            "lg_45" => "Xbox Series X",
            "lg_46" => "Playstation 4",
            "lg_47" => "Nintendo Switch",
            "lg_48" => "Keyboards",
            "lg_49" => "Sades",
            "lg_50" => "Nanoleaf",
            "lg_51" => "Gaming mouse",
            "lg_52" => "Logitech",
            "lg_53" => "Release Date",
            "lg_54" => "Pre Order",
            "lg_55" => "Out of stock",
            "lg_56" => "View details",
            "lg_57" => "Tel",
            "lg_58" => "Our Store Locations",
            "lg_59" => "DUBAI",
            "lg_60" => "DUBAI MALL",
            "lg_61" => "2nd Floor",
            "lg_62" => "Timing",
            "lg_63" => "Week days",
            "lg_64" => "Weekends",
            "lg_65" => "am",
            "lg_66" => "pm",
            "lg_67" => "DUBAI HILLS MALL",
            "lg_68" => "Address",
            "lg_69" => "1st Floor",
            "lg_70" => "SHARJAH",
            "lg_71" => "Shop N° B093",
            "lg_72" => "Nearest Parking Gate A L2es",
            "lg_73" => "",
            "lg_74" => "JEDDAH",
            "lg_75" => "SOUK AL SHATIE",
            "lg_76" => "Al Zahra Street, Ahmad al Attas near Shelves, Jeddah 23425",
            "lg_77" => "am",
            "lg_7-8" => "pm",
            "lg_78" => "AL WARQA",
            "lg_79" => "Al Warqa - Al Warqa 1",
            "lg_80" => "CITY CENTER AL ZAHIA",
            "lg_81" => "More",
            "lg_82" => "Offers",
            "lg_83" => "Login",
            "lg_84" => "Register",
            "lg_85" => "Search",
            "lg_86" => "Checkout",
            "lg_87" => "view cart",
            "lg_88" => "My Profile",
            "lg_89" => "Change Password",
            "lg_90" => "Logout",
            "lg_91" => "Buy Now",
            "lg_92" => "TRENDING PRODUCTS",
            "lg_93" => "NEW IN PC GAMING",
            "lg_94" => "HEADSETS BEST SELLERS",
            "lg_95" => "CONTROLLERS BEST SELLERS",
            "lg_96" => "BEST IN ADVENTURE GAMES",
            "lg_97" => "BEST IN RPG GAMES",
            "lg_98" => "BEST IN SERIES X",
            "lg_99" => "BEST IN FIGHTING GAMES",
            "lg_100" => "Accessories",
            "lg_101" => "Shop by price",
            "lg_102" => CURRENCY,
            "lg_103" => "PS5 disk edition",
            "lg_104" => "PS5 bundles",
            "lg_105" => "Sony dualsense",
            "lg_106" => "Nacon",
            "lg_107" => "Xbox Series X|S",
            "lg_108" => "HyperX",
            "lg_109" => "Razer",
            "lg_110" => "Turtle Beach",
            "lg_111" => "Virtual Reality Headset",
            "lg_112" => "GPU & PC Cases",
            "lg_113" => "E-scooters",
            "lg_114" => "Gaming Lights",
            "lg_115" => "Gaming Backpacks",
            "lg_116" => "Figures & Collectibles",
            "lg_117" => "Gaming Chairs",
            "lg_118" => "I'm looking for",
            "lg_119" => "Home",
            "lg_120" => "Newest To Oldest",
            "lg_121" => "Oldest To Newest",
            "lg_122" => "Price Highest To Lowest",
            "lg_123" => "Price Lowest To Highest",
            "lg_124" => "Filter by",
            "lg_125" => "Sort By",
            "lg_126" => "Filter",
            "lg_127" => "clear all filters",
            "lg_128" => "Type",
            "lg_129" => "Brands",
            "lg_130" => "Age",
            "lg_131" => "Suitable for",
            "lg_132" => "Genre",
            "lg_133" => "Price",
            "lg_134" => "New arrival",
            "lg_135" => "Freebie",
            "lg_136" => "Evergreen",
            "lg_137" => "Exclusive",
            "lg_138" => "Yes",
            "lg_139" => "of",
            "lg_140" => "Products showing",
            "lg_141" => "Load More",
            "lg_142" => "Products",
            "lg_143" => "showing",
            "lg_144" => "Login to your account",
            "lg_145" => "using your E-mail ID",
            "lg_146" => "Create account",
            "lg_147" => "I have read and agree to the",
            "lg_148" => "Name",
            "lg_148-1" => "First name",
            "lg_148-2" => "Last name",
            "lg_149" => "Phone number without country code",
            "lg_150" => "Password",
            "lg_151" => "Confirm password",
            "lg_152" => "Forgot your password?",
            "lg_153" => "Login with OTP",
            "lg_154" => "using your Phone number",
            "lg_155" => "Send OTP",
            "lg_156" => "Login with Email",
            "lg_157" => "Enter the digits",
            "lg_158" => "Resend",
            "lg_159" => "Confirm OTP",
            "lg_160" => "Enter the registred E-mail ID",
            "lg_161" => "Send the link",
            "lg_162" => "Back to login",
            "lg_163" => "Checkout as a Guest",
            "lg_164" => "Continue",
            "lg_165" => "Form requested not found",
            "lg_166" => "Previous",
            "lg_167" => "Next",
            "lg_168" => "Fullscreen",
            "lg_169" => "Pause",
            "lg_170" => "Brand",
            "lg_171" => "Limited stock quantity",
            "lg_172" => "Limited order quantity",
            "lg_173" => "Assemble Professionally",
            "lg_174" => "Suitable for age",
            "lg_175" => "Delivery Available",
            "lg_176" => "share",
            "lg_177" => "Description",
            "lg_178" => "Features",
            "lg_179" => "Other images",
            "lg_180" => "Related Products",
            "lg_181" => "Reviews",
            "lg_182" => "Review this product",
            "lg_183" => "Review product",
            "lg_184" => "Rate this product",
            "lg_185" => "Your opinion",
            "lg_186" => "Close",
            "lg_187" => "Submit",
            "lg_188" => "Tell us what you think...",
            "lg_189" => "No reviews for this product",
            "lg_190" => "MATCHING CATEGORIES",
            "lg_191" => "No result found!",
            "lg_192" => "MATCHING BRANDS",
            "lg_193" => "Basket",
            "lg_194" => "each",
            "lg_195" => "No",
            "lg_196" => "Cart is empty!",
            "lg_197" => "Gift wrapping",
            "lg_198" => "Total",
            "lg_198-1" => "Total (inc VAT)",
            "lg_199" => "Checkout now",
            "lg_200" => "Continue shopping",
            "lg_201" => "Our website is 100% encrypted and your personal details are safe",
            "lg_202" => "Add Freebie Products",
            "lg_203" => "You are eligible to add only",
            "lg_204" => "Add selected Freebie to cart",
            "lg_205" => "freebie products",
            "lg_206" => "Warning!",
            "lg_207" => "Loading",
            "lg_208" => "Delivery Address",
            "lg_209" => "Change",
            "lg_210" => "Select payment method",
            "lg_211" => "Use my wallet",
            "lg_212" => "Available balance",
            "lg_213" => "Use",
            "lg_214" => "to get",
            "lg_215" => "Discount",
            "lg_216" => "Coupon discount",
            "lg_217" => "Go to Cart",
            "lg_218" => "checkout as Guest",
            "lg_219" => "Enter promo code",
            "lg_220" => "Use a coupon code",
            "lg_221" => "Street",
            "lg_222" => "City",
            "lg_223" => "Select city",
            "lg_224" => "Edit Profile Form",
            "lg_225" => "Country code",
            "lg_226" => "Phone",
            "lg_227" => "Profile Image",
            "lg_228" => "Upload file",
            "lg_229" => "Save",
            "lg_230" => "Change Password Form",
            "lg_231" => "Old Password",
            "lg_232" => "New Password",
            "lg_233" => "Update Address",
            "lg_234" => "Apartment/House No.",
            "lg_235" => "Status",
            "lg_236" => "Select status",
            "lg_237" => "Active",
            "lg_238" => "Inactive",
            "lg_239" => "My Address",
            "lg_240" => "Address list is empty!",
            "lg_241" => "Wishlist",
            "lg_242" => "Remove",
            "lg_243" => "Your wish list is empty.",
            "lg_244" => "Order",
            "lg_245" => "Date",
            "lg_246" => "Payment",
            "lg_247" => "Track",
            "lg_248" => "Invoice",
            "lg_249" => "Action",
            "lg_250" => "Cancel",
            "lg_251" => "Edit Profile",
            "lg_252" => "My Wallet",
            "lg_253" => "My Wishlist",
            "lg_254" => "My Orders",
            "lg_255" => "Add Address",
            "lg_256" => "Add Money",
            "lg_257" => "Current Balance",
            "lg_258" => "Total Used",
            "lg_259" => "Refuned to card",
            "lg_260" => "Order Date",
            "lg_261" => "card",
            "lg_262" => "order cancel",
            "lg_263" => "Refunded",
            "lg_264" => "Refund",
            "lg_265" => "Add money to wallet",
            "lg_266" => "Enter Amount",
            "lg_267" => "Account",
            "lg_268" => "TAX INVOICE",
            "lg_269" => "Customer information",
            "lg_270" => "Order information",
            "lg_271" => "Full name",
            "lg_272" => "Invoice date",
            "lg_273" => "Issue date",
            "lg_274" => "Phone number",
            "lg_275" => "Order ID",
            "lg_276" => "E-mail",
            "lg_277" => "Order status",
            "lg_278" => "SKU",
            "lg_279" => "Quantity",
            "lg_280" => "Price excl VAT",
            "lg_281" => "VAT",
            "lg_282" => "Payment details",
            "lg_283" => "Payment status",
            "lg_284" => "Subtotal (excl VAT)",
            "lg_284-1" => "Subtotal",
            "lg_285" => "Total VAT",
            "lg_286" => "Payable amount",
            "lg_287" => "THANK YOU FOR SHOPPING WITH ZGAMES!",
            "lg_288" => "Select an option*",
            "lg_289" => "Our Address",
            "lg_290" => "Send Message",
            "lg_291" => "Subject",
            "lg_292" => "Message",
            "lg_293" => "United Arab Emirates",
            "lg_294" => "Saudi Arabia",
            "lg_295" => "Qatar",
            "lg_296" => "Bahrain",
            "lg_297" => "Oman",
            "lg_298" => "Get a quote",
            "lg_299" => "Request a callback",
            "lg_300" => "Motherboard",
            "lg_301" => "Processor",
            "lg_302" => "Graphic card",
            "lg_303" => "HardDrive - SSD",
            "lg_304" => "HardDrive - SATA",
            "lg_305" => "Memory module - RAM",
            "lg_306" => "Chasis / Tower",
            "lg_307" => "Power supply",
            "lg_308" => "Case fans",
            "lg_309" => "Cooling system",
            "lg_310" => "Select an operating system",
            "lg_311" => "Windows 10",
            "lg_312" => "Windows 11",
            "lg_313" => "Additional accessories",
            "lg_314" => "Send",
            "lg_315" => "Customize your Gaming PC",
            "lg_316" => "GET <br> A QUOTE",
            "lg_317" => "Print",
            "lg_318" => "Date of birth",
            "lg_319" => "Total charges",
            "lg_320" => "Shop more",
            "lg_321" => "Add some",
            "lg_322" => "items",
            "lg_323" => "to your cart",
            "lg_324" => "Order summary",
            "lg_325" => "Opening soon",
            "lg_326" => "Gallery",
            "lg_327" => "About the store",
            "lg_328" => "Thank you!",
            "lg_329" => "Please proceed to",
            "lg_330" => "first",
            "lg_331" => "Top Brands",
            "lg_332" => "Items added to cart",
            "lg_333" => "Other",
            "lg_334" => "Login with",
            "lg_335" => "Blogs",
            "lg_336" => "Results for",
            "lg_337" => "GAMING MERCHANDISE",
            "lg_338" => "VIDEO GAMES",
            "lg_339" => "CONTROLLERS",
            "lg_340" => "FIGURINES",
            "lg_341" => "CONSOLES",
            "lg_342" => "MONITORS",
            "lg_343" => "Enjoy 0% interest for 6 or 12 months on 1k or more spent",
            "lg_344" => "ENBD Easy installment plan",
            "lg_345" => "Learn more",
            "lg_346" => "Welcome to the ZGames Newsletter - Thank you for subscribing! Here is what happens next!",
            "lg_347" => "You are now automatically in the draw to WIN the Armored Core VI Fires of Rubicon Collector Edition.",
            "lg_348" => "Good Luck!",
            "lg_349" => "You are already sumbscribed <br> Thank you for your intrest.",
            "lg_350" => "My digital codes",
            "lg_351" => "Code details",
            "lg_352" => "Product title",
            "lg_353" => "Pay in 4. No intrest no fees.",
            "lg_354" => "Sorry, Tabby is unable to approve this purchase.<br> Please use an alternative payment method for your order.",
            "lg_355" => "This purchase is above your current spending limit with Tabby,<br> try a smaller cart or use another payment method",
            "lg_356" => "The purchase amount is below the minimum amount required to use Tabby, try adding more items or use another payment method",
            "lg_357" => "Sorry We are not able to finish the checkout with the selected payment method. <br>Please choose another method",
            "lg_358" => "Gaming PC",
            "lg_359" => "CONSOLE SKINS",
            "lg_360" => "Action Games",
            "lg_361" => "Gaming Stuff",
            "lg_362" => "The offer",
            "lg_363" => "Applicable",
            "lg_364" => "worth of",
            "lg_365" => "Will be applied",
            "lg_366" => ", You will get the following prize:",
            "lg_367" => ", You will get the following items for free:",
            "lg_368" => "is applied!",
            "lg_369" => "Prizes are choosen randomly. Refresh the page to generate new prize.",
            "lg_370" => "Includes:",
            "lg_371" => "Gaming Monitors",
            "lg_372" => "Shop in Paladon",
            "lg_373" => "Online stores",
            "lg_374" => "UAE",
            "lg_375" => "KSA",
            "lg_376" => "",
            "lg_377" => "",
            "lg_378" => "",
            "lg_379" => "Stock",
            "lg_380" => "In Stock",
            "lg_381" => "PC & Consoles",
            "lg_382" => "Merchandize",
            "lg_383" => "All Products",
            "lg_384" => "Pick one item",
            "lg_385" => "Pay less with the offer",
            "lg_386" => "Shop in Spider-man",
            "lg_387" => "PC Parts",
            "lg_388" => "Racing Corner",
            "lg_389" => "Marvel Corner",
            "lg_390" => "New in Collectibles",
            "lg_391" => "Bundle Offers",
            "lg_392" => "New in Gaming Merchandise",
            "lg_393" => "المنطقة",
            "lg_393" => "Region",


        ),

        "AR" => array(
            "lg_01" => "زيجايمز",
            "lg_02" => "معلومات",
            "lg_03" => "معلومات عنّا",
            "lg_04" => "اتصل بنا",
            "lg_05" => "الأحكام والشّروط",
            "lg_06" => "سياسة الخصوصية",
            "lg_07" => "الأسئلة الأكثر شيوعا",
            "lg_08" => "معلومات التوصيل",
            "lg_09" => "سياسة الاسترجاع",
            "lg_10" => "متاجرنا",
            "lg_11" => "فئات",
            "lg_12" => "تابعنا",
            "lg_13" => "الموقع",
            "lg_14" => "نقبل وسائل الدفع التالية",
            "lg_15" => "اشترك في منشوراتنا الإخبارية",
            "lg_16" => "اشترك",
            "lg_17" => "عنوان البريد الالكترونى",
            "lg_18" => "تسوق وفق الماركة",
            "lg_19" => "المزيد في الإكسسوارات",
            "lg_20" => "المزيد في الألعاب",
            "lg_21" => "تسوق الألعاب حسب النوع",
            "lg_22" => "آتي قريبا",
            "lg_23" => "جديد في الإكسسوارات",
            "lg_24" => "بلايستيشن",
            "lg_25" => "اكس بوكس",
            "lg_26" => "أفضل العروض",
            "lg_27" => "تسوق حسب الاقسام",
            "lg_28" => "ألعاب",
            "lg_29" => "أجهزة التحكم",
            "lg_30" => "سماعات",
            "lg_31" => "وحدات تحكم",
            "lg_32" => "مشاهدة الكل",
            "lg_33" => "أضف إلى السلة",
            "lg_34" => "الطلبات المسبقة",
            "lg_35" => "سكويراينيكس",
            "lg_36" => "الإصدارات الجديدة",
            "lg_37" => "الكترونيك آرتس",
            "lg_38" => "افضل العروض",
            "lg_39" => "كابكوم",
            "lg_40" => "يوبيسوفت",
            "lg_41" => "بانداي",
            "lg_42" => "بلايستيشن 5",
            "lg_43" => "اكس بوكس وان",
            "lg_44" => "اكس بوكس سيريز أس",
            "lg_45" => "اكس بوكس سيريز أكس",
            "lg_46" => "بلايستيشن 4",
            "lg_47" => "ننتندو سويتش",
            "lg_48" => "لوحات المفاتيح",
            "lg_49" => "سايدز",
            "lg_50" => "نانوليف",
            "lg_51" => "ماوس الألعاب",
            "lg_52" => "لوجيتاك",
            "lg_53" => "تاريخ الاصدار",
            "lg_54" => "طلب مسبق",
            "lg_55" => "إنتهى من المخزن",
            "lg_56" => "عرض التفاصيل",
            "lg_57" => "هاتف",
            "lg_58" => "مواقع متجرنا",
            "lg_59" => "دبي",
            "lg_60" => "مول دبي",
            "lg_61" => "الطابق 2",
            "lg_62" => "التوقيت",
            "lg_63" => "أيام الأسبوع",
            "lg_64" => "عطلات نهاية الأسبوع",
            "lg_65" => "صباحا",
            "lg_66" => "مساءً",
            "lg_67" => "دبي هيلز مول",
            "lg_68" => "عنوان",
            "lg_69" => "الطابق الأول",
            "lg_70" => "الشارقة",
            "lg_71" => "متجر رقم B093",
            "lg_72" => "L2es أقرب موقف سيارات بوابةأ ",
            "lg_73" => "",
            "lg_74" => "جدّة",
            "lg_75" => "سوق الشّاطئ",
            "lg_76" => "شارع الزهراء أحمد العطاس بجوار الرفوف جدة 23425",
            "lg_77" => "صباحًا",
            "lg_7-8" => "مساءًا",
            "lg_78" => "الورقاء",
            "lg_79" => "الورقاء - الورقاء 1",
            "lg_80" => "سيتي سنتر الزاهية",
            "lg_81" => "المزيد",
            "lg_82" => "عروض",
            "lg_83" => "تسجيل الدخول",
            "lg_84" => "تسجيل",
            "lg_85" => "بحث",
            "lg_86" => "الدفع",
            "lg_87" => "عرض عربة التسوق",
            "lg_88" => "ملفي",
            "lg_89" => "تغيير كلمة السر",
            "lg_90" => "تسجيل خروج",
            "lg_91" => "اشتر الآن",
            "lg_92" => "منتجات رائجة",
            "lg_93" => "الجديد في ألعاب الكمبيوتر الشخصي",
            "lg_94" => "أفضل مبيعا سماعات الرأس",
            "lg_95" => "أفضل مبيعا وحدات التحكم",
            "lg_96" => "الأفضل في ألعاب المغامرة",
            "lg_97" => "الأفضل في ألعاب تقمص الأدوار",
            "lg_98" => "الأفضل في سيريز أكس",
            "lg_99" => "الأفضل في ألعاب القتال",
            "lg_100" => "أكسسوارات",
            "lg_101" => "تسوق حسب السعر",
            "lg_102" => "دإ",
            "lg_103" => "بلايستيشن 5 اصدار القرص",
            "lg_104" => "حزم بلايستيشن 5",
            "lg_105" => "سوني ديال سانس",
            "lg_106" => "ناكون",
            "lg_107" => "اكسبوكس سيريز أكس|أس",
            "lg_108" => "هايبرأكس",
            "lg_109" => "رايزر",
            "lg_110" => "ترتل بيتش",
            "lg_111" => "سماعات الواقع الافتراضي",
            "lg_112" => "بطاقات الرسومات و صناديق الكمبيوتر",
            "lg_113" => "الدراجات البخارية الإلكترونية",
            "lg_114" => "أضواء الألعاب",
            "lg_115" => "حقائب ظهر للألعاب",
            "lg_116" => "التماتيل والمقتنيات",
            "lg_117" => "كراسي الألعاب",
            "lg_118" => "أبحث عن",
            "lg_119" => "الصفحة الرئيسية",
            "lg_120" => "من الأحدث إلى الأقدم",
            "lg_121" => "من الأقدم إلى الأحدث",
            "lg_122" => "السعر من الأعلى إلى الأدنى",
            "lg_123" => "السعر من الأدنى إلى الأعلى",
            "lg_124" => "تصنيف حسب",
            "lg_125" => "ترتيب حسب",
            "lg_126" => "تصفية",
            "lg_127" => "مسح كل عوامل التصفية",
            "lg_128" => "نوع",
            "lg_129" => "الماركات",
            "lg_130" => "التصنيف العمري",
            "lg_131" => "مناسب لـ",
            "lg_132" => "نوع اللعبة",
            "lg_133" => "السعر",
            "lg_134" => "وصول جديد",
            "lg_135" => "الهدية الترويجية",
            "lg_136" => "دائم الخضرة",
            "lg_137" => "حصرية",
            "lg_138" => "نعم",
            "lg_139" => "من",
            "lg_140" => "منتج معروض",
            "lg_141" => "تحميل المزيد",
            "lg_142" => "منتجات",
            "lg_143" => "معروض",
            "lg_144" => "سجل الدخول إلى حسابك",
            "lg_145" => "باستخدام معرف البريد الإلكتروني الخاص بك",
            "lg_146" => "انشاء حساب",
            "lg_147" => "لقد قرأت ووافقت على",
            "lg_148" => "الاسم",
            "lg_148-1" => "الاسم",
            "lg_148-2" => "اللّقب",
            "lg_149" => "رقم الهاتف بدون رمز الدولة",
            "lg_150" => "كلمة المرور",
            "lg_151" => "تأكيد كلمة المرور",
            "lg_152" => "نسيت كلمة السر؟",
            "lg_153" => "تسجيل الدخول باستخدام OTP",
            "lg_154" => "باستخدام رقم هاتفك",
            "lg_155" => "إرسال OTP",
            "lg_156" => "تسجيل الدخول بالبريد الإلكتروني",
            "lg_157" => "أدخل الأرقام",
            "lg_158" => "إعادة الإرسال",
            "lg_159" => "تأكيد OTP",
            "lg_160" => "أدخل معرف البريد الإلكتروني المسجل",
            "lg_161" => "أرسل الرابط",
            "lg_162" => "العودة إلى تسجيل الدخول",
            "lg_163" => "دفع كزائر",
            "lg_164" => "متابعة",
            "lg_165" => "النموذج المطلوب غير موجود",
            "lg_166" => "سابق",
            "lg_167" => "التالي",
            "lg_168" => "شاشة كاملة",
            "lg_169" => "وقف",
            "lg_170" => "الماركة",
            "lg_171" => "كمية محدودة",
            "lg_172" => "كمية الطلب محدودة",
            "lg_173" => "Assemble Professionally",
            "lg_174" => "مناسب للأعمار",
            "lg_175" => "التوصيل متوفر",
            "lg_176" => "شارك",
            "lg_177" => "وصف",
            "lg_178" => "الميزات",
            "lg_179" => "صور أخرى",
            "lg_180" => "منتجات ذات صله",
            "lg_181" => "المراجعات",
            "lg_182" => "قم بمراجعة هذا المنتج",
            "lg_183" => "مراجعة المنتج",
            "lg_184" => "قيم هذا المنتج",
            "lg_185" => "رأيك",
            "lg_186" => "غلق",
            "lg_187" => "تقديم",
            "lg_188" => "...أخبرنا عن رأيك",
            "lg_189" => "لا توجد مراجعات لهذا المنتج",
            "lg_190" => "فئات مطابقة",
            "lg_191" => "لم يتم العثور على نتائج!",
            "lg_192" => "الماركات المتطابقة",
            "lg_193" => "سلة",
            "lg_194" => "للواحد",
            "lg_195" => "لا",
            "lg_196" => "السلة فارغة",
            "lg_197" => "تغليف الهدايا",
            "lg_198" => "المجموع",
            "lg_198-1" => "الإجمالي شاملاً ضريبة القيمة المضافة",
            "lg_199" => "أدفع الآن",
            "lg_200" => "مواصلة التسوق",
            "lg_201" => "موقعنا مشفر بنسبة 100٪ وبياناتك الشخصية آمنة",
            "lg_202" => "أضف منتجات مهدات",
            "lg_203" => "أنت مؤهل لإضافة فقط",
            "lg_204" => "أضف الهدية الترويجية المختارة إلى عربة التسوق",
            "lg_205" => "منتجات الهدية الترويجية",
            "lg_206" => "تحذير!",
            "lg_207" => "جار التحميل",
            "lg_208" => "عنوان التسليم",
            "lg_209" => "تغيير",
            "lg_210" => "اختر طريقة الدفع او السداد",
            "lg_211" => "استخدم محفظتي",
            "lg_212" => "الرصيد المتوفر",
            "lg_213" => "استخدم",
            "lg_214" => "للحصول على",
            "lg_215" => "تخفيض",
            "lg_216" => "خصم القسيمة",
            "lg_217" => "عربة التسوق",
            "lg_218" => "الدفع كضيف",
            "lg_219" => "إدخال الرمز الترويجي",
            "lg_220" => "استخدم رمز القسيمة",
            "lg_221" => "الشارع",
            "lg_222" => "المدينة",
            "lg_223" => "اختر المدينة",
            "lg_224" => "تعديل نموذج ملف التعريف",
            "lg_225" => "الرقم الدولي",
            "lg_226" => "الهاتف",
            "lg_227" => "صورة الملف الشخصي",
            "lg_228" => "رفع ملف",
            "lg_229" => "حفظ",
            "lg_230" => "نموذج تغيير كلمة السر",
            "lg_231" => "كلمة السر القديمة",
            "lg_232" => "كلمة السر الجديدة",
            "lg_233" => "تحديث العنوان",
            "lg_234" => "رقم الشقة / المنزل",
            "lg_235" => "الحالة",
            "lg_236" => "حدد الحالة",
            "lg_237" => "نشيط",
            "lg_238" => "غير نشط",
            "lg_239" => "عنواني",
            "lg_240" => "قائمة العناوين فارغة!",
            "lg_241" => "قائمة الرغبات",
            "lg_242" => "إزالة",
            "lg_243" => "قائمة رغباتك فارغة.",
            "lg_244" => "طلب",
            "lg_245" => "التاريخ",
            "lg_246" => "الدفع",
            "lg_247" => "تتبع",
            "lg_248" => "الفاتورة",
            "lg_249" => "تفعيل",
            "lg_250" => "الغاء",
            "lg_251" => "تعديل الملف الشخصي",
            "lg_252" => "محفظتى",
            "lg_253" => "قائمة رغباتي",
            "lg_254" => "طلباتي",
            "lg_255" => "اضف عنوان",
            "lg_256" => "إضافة المال",
            "lg_257" => "الرصيد الحالي",
            "lg_258" => "إجمالي المستخدم",
            "lg_259" => "رد الأموال إلى البطاقة",
            "lg_260" => "تاريخ الطلب",
            "lg_261" => "بطاقة",
            "lg_262" => "إلغاء الطلب",
            "lg_263" => "معاد",
            "lg_264" => "استرداد",
            "lg_265" => "أضف الأموال إلى المحفظة",
            "lg_266" => "أدخل المبلغ",
            "lg_267" => "الحساب",
            "lg_268" => "فاتورة",
            "lg_269" => "معلومات العميل",
            "lg_270" => "معلومات الطلب",
            "lg_271" => "الاسم الكامل",
            "lg_272" => "تاريخ الفاتورة",
            "lg_273" => "تاريخ الإصدار",
            "lg_274" => "رقم الهاتف",
            "lg_275" => "رقم بالطلب",
            "lg_276" => "البريد الإلكتروني",
            "lg_277" => "حالة الطلب",
            "lg_278" => "SKU",
            "lg_279" => "الكمية",
            "lg_280" => "السعر دون ضريبة القيمة المضافة",
            "lg_281" => "ضريبة القيمة المضافة",
            "lg_282" => "بيانات الدفع",
            "lg_283" => "حالة السداد",
            "lg_284" => "المجموع الفرعي (بدون ضريبة القيمة المضافة)",
            "lg_284-1" => "المجموع الفرعي",
            "lg_285" => "إجمالي ضريبة القيمة المضافة",
            "lg_286" => "المبلغ المستحق",
            "lg_287" => "نشكرك على التسوق مع زيجايمز!",
            "lg_288" => "حدد اختيارا*",
            "lg_289" => "عنواننا",
            "lg_290" => "أرسل رسالة",
            "lg_291" => "الموضوع",
            "lg_292" => "الرسالة",
            "lg_293" => "الإمارات العربية المتحدة",
            "lg_294" => "المملكة العربية السعودية",
            "lg_295" => "قطر",
            "lg_296" => "البحرين",
            "lg_297" => "سلطنة عمان",
            "lg_298" => "أحصل على تسعيرة",
            "lg_299" => "طلب اتصال",
            "lg_300" => "البطاقة الأم",
            "lg_301" => "المعالج",
            "lg_302" => "بطاقة الرسومات",
            "lg_303" => "القرص الصلب - SSD",
            "lg_304" => "القرص الصلب - SATA",
            "lg_305" => "وحدة الذاكرة - RAM",
            "lg_306" => "الهيكل / العلبة",
            "lg_307" => "مزود الطاقة",
            "lg_308" => "علبة المراوح",
            "lg_309" => "نظام التبريد",
            "lg_310" => "حدد نظام تشغيل",
            "lg_311" => "نظام التشغيل ويندوز 10",
            "lg_312" => "نظام التشغيل ويندوز 11",
            "lg_313" => "ملحقات إضافية",
            "lg_314" => "ارسال",
            "lg_315" => "قم بتخصيص كمبيوتر الألعاب الخاص بك",
            "lg_316" => "أحصل على <br> تسعيرة",
            "lg_317" => "طبع",
            "lg_318" => "تاريخ الميلاد",
            "lg_319" => "الكلفة الاجماليه",
            "lg_320" => "تسوق أكثر",
            "lg_321" => "اضف بعض",
            "lg_322" => "العناصر",
            "lg_323" => "إلى عربة التسوق الخاصة بك",
            "lg_324" => "ملخص الطلب",
            "lg_325" => "قريبا الإفتتاح",
            "lg_326" => "صور المتجر",
            "lg_327" => "معلومات عن المتجر",
            "lg_328" => "شكرا",
            "lg_329" => "يرجى تفعيل",
            "lg_330" => "أولا",
            "lg_331" => "أفضل الماركات",
            "lg_332" => "عناصر مضافة إلى عربة التسوق",
            "lg_333" => "فئات أخرى",
            "lg_334" => "تسجيل الدخول بـ",
            "lg_335" => "المدونات",
            "lg_336" => "نتائج البحث لـ",
            "lg_337" => "بضائع الألعاب",
            "lg_338" => "ألعاب الفيديو",
            "lg_339" => "وحدات التحكم",
            "lg_340" => "التماثيل",
            "lg_341" => "أجهزة التحكم",
            "lg_342" => "الشاشات",
            "lg_343" => "استمتع بتقسيط 6 أو 12 أشهر مقابل 0% فائدة عند انفااق 1000 درهم أو أكثر",
            "lg_344" => "بنك الإمارات دبي الوطني خطة التقسيط السهلة",
            "lg_345" => "المزيد",
            "lg_346" => "مرحبًا بك في النشرة الإخبارية لـ ZGames - شكرًا لك على الاشتراك! إليك ما سيحدث بعد ذلك!",
            "lg_347" => "أنت الآن تلقائياً في السحب للفوز بجائزة أرمورد كور فايرز أف روبيكان كلكتر",
            "lg_348" => "!حظ سعيد",
            "lg_349" => "لقد تم اشتراكك بالفعل <br> شكرًا لك على اهتمامك.",
            "lg_350" => "رموزي الرقمية",
            "lg_351" => "تفاصيل الكود",
            "lg_352" => "عنوان المنتج",
            "lg_353" => "ادفع على 4. لا فائدة ولا رسوم.",
            "lg_354" => "نأسف، تابي غير قادرة على الموافقة على هذه العملية.<br> الرجاء استخدام طريقة دفع أخرى.",
            "lg_355" => "قيمة الطلب تفوق الحد الأقصى المسموح به حاليًا مع تابي. <br> يُرجى تخفيض قيمة السلة أو استخدام وسيلة دفع أخرى.",
            "lg_356" => "قيمة الطلب أقل من الحد الأدنى المطلوب لاستخدام خدمة تابي. <br> يُرجى زيادة قيمة الطلب أو استخدام وسيلة دفع أخرى.",
            "lg_357" => "عذرًا، لا يمكننا إنهاء عملية الدفع باستخدام طريقة الدفع المحددة. <br>الرجاء اختيار طريقة أخرى",
            "lg_358" => "كمبيوتر الألعاب",
            "lg_359" => "جلود وحدات التحكم",
            "lg_360" => "الأفضل في ألعاب الأكشن",
            "lg_361" => "أشياء الألعاب",
            "lg_362" => "العرض",
            "lg_363" => "قابل للتطبيق",
            "lg_364" => "بقيمة",
            "lg_365" => "سيتم تطبيقه",
            "lg_366" => ",سوف تحصل على الجائزة التالية:",
            "lg_367" => "، سوف تحصل على العناصر التالية مجاناً:",
            "lg_368" => "تم تطبيقه",
            "lg_369" => "يتم اختيار الجوائز بشكل عشوائي. قم بتحديث الصفحة للحصول على جائزة جديدة.",
            "lg_370" => "يشمل:",
            "lg_371" => "شاشات الألعاب",
            "lg_372" => "تسوق في بالادون",
            "lg_373" => "مواقعنا",
            "lg_374" => "الإمارات",
            "lg_375" => "السعودية",
            "lg_376" => "",
            "lg_377" => "",
            "lg_378" => "",
            "lg_379" => "المخزون",
            "lg_380" => "متوفر",
            "lg_381" => "أجهزة الكمبيوتر ووحدات التحكم",
            "lg_382" => "بضائع",
            "lg_383" => "جميع المنتجات",
            "lg_384" => "اختر عنصرًا",
            "lg_385" => "ادفع أقل مع عرض",
            "lg_386" => "تسوق في سبايدر مان",
            "lg_387" => "أجزاء الكمبيوتر",
            "lg_388" => "ركن السباق",
            "lg_389" => "ركن مارفل",
            "lg_390" => "الجديد في المقتنيات",
            "lg_391" => "عروض الباقة",
            "lg_392" => "الجديد في سلع الألعاب",
            "lg_393" => "المنطقة",





        )
    );
    
    if(array_key_exists($lg_code , $lg_texts) && array_key_exists($txt_code , $lg_texts[$lg_code]))
    return $lg_texts[$lg_code][$txt_code];
    else
    return $lg_texts["EN"][$txt_code];


}

}

if(!function_exists("lg_get_msg")){

    function lg_get_msg($txt_code){
        $lg_code = get_cookie("language");
        $lg_texts = array(
            "EN"=> array(
                "lg_01" => "",
                "lg_02" => "",
                "lg_03" => "",
                "lg_04" => "",
                "lg_05" => "",
                "lg_06" => "",
                "lg_07" => "",
                "lg_08" => "",
                "lg_09" => "",
                "lg_10" => "",
                "lg_11" => "",
                "lg_12" => "",
                "lg_13" => "",
                "lg_14" => "",
                "lg_15" => "",
                "lg_16" => "",
                "lg_17" => "",
                "lg_19" => "",
                "lg_20" => "",
                "lg_21" => "",
                "lg_22" => "",
                "lg_23" => "",
                "lg_24" => "",
                "lg_25" => "",
                "lg_26" => "",
                "lg_27" => "",
                "lg_28" => "",
                "lg_29" => "",
                "lg_30" => "",
            ),

            "AR"=> array(
                "lg_01" => "",
            )
        );

        if(array_key_exists($lg_code , $lg_texts) && array_key_exists($txt_code , $lg_texts[$lg_code]))
        return $lg_texts[$lg_code][$txt_code];
        else
        return $lg_texts["EN"][$txt_code];

    }

}


if(!function_exists("content_from_right")){

    function content_from_right($echo=true){
            switch (get_cookie("language")) {
                case 'AR':
                    # code...
                    if($echo)
                    echo 'dir="rtl"';
                    else
                    return 'dir="rtl"';
                    break;
                
                default:
                    # code...
                    echo '';
                    break;
            }
    }

}

if(!function_exists("text_from_right")){

    function text_from_right($display = true){
            switch (get_cookie("language")) {
                case 'AR':
                    # code...
                    if($display)
                    echo 'text-right';
                    else
                    return 'text-right';
                    break;
                
                default:
                    # code...
                    echo "";
                    break;
            }
    }

}

if(!function_exists("text_from_left")){

    function text_from_left($display = true){
            switch (get_cookie("language")) {
                case 'AR':
                    # code...
                    if($display)
                    echo 'text-left';
                    else
                    return 'text-left';
                    break;
                
                default:
                    # code...
                    if($display)
                    echo 'text-right';
                    else
                    return 'text-right';
                    break;
            }
    }

}


if(!function_exists("content_reversed")){

    function content_reversed(){
            switch (get_cookie("language")) {
                case 'AR':
                    # code...
                    echo 'flex-row-reverse';
                    break;
                
                default:
                    # code...
                    echo '';
                    break;
            }
    }

}


if(!function_exists("lg_put_text")){
    function lg_put_text($eng_text , $ara_text , $echo=true){

        if($echo){
            if(get_cookie("language") == "AR"){
                if($ara_text !== null && trim($ara_text) !== "")
                echo $ara_text;
                else echo $eng_text;
            }

    
            else
            echo $eng_text;
            
        }
        else{
            if(get_cookie("language") == "AR"){
                if($ara_text !== null && trim($ara_text) !== "")
                return $ara_text;
                else return $eng_text;
            }
            else
            return $eng_text;

            
        }
         
    }
}



?>