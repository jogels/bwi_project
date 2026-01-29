-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2024 at 04:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bwi_db_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `title` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `title`) VALUES
(1, 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `banner_photos`
--

CREATE TABLE `banner_photos` (
  `id` int(11) NOT NULL,
  `banner_id` int(11) NOT NULL,
  `photo_url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banner_photos`
--

INSERT INTO `banner_photos` (`id`, `banner_id`, `photo_url`) VALUES
(2, 1, 'image/uploads/Banner/1/2/2024121733572010.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `created_at`) VALUES
(1, 'Jakarta Barat', '2024-12-07 13:00:38'),
(2, 'Jakarta Selatan', '2024-12-07 13:02:23');

-- --------------------------------------------------------

--
-- Table structure for table `company_profiles`
--

CREATE TABLE `company_profiles` (
  `id` int(11) NOT NULL,
  `profile_type` enum('about','organization_structure') DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_profile_attachments`
--

CREATE TABLE `company_profile_attachments` (
  `id` int(11) NOT NULL,
  `company_profile_id` int(11) DEFAULT NULL,
  `attachment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_profile_photos`
--

CREATE TABLE `company_profile_photos` (
  `id` int(11) NOT NULL,
  `company_profile_id` int(11) DEFAULT NULL,
  `photo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `literations`
--

CREATE TABLE `literations` (
  `id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `literation_type_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `literation_types`
--

CREATE TABLE `literation_types` (
  `id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `url`, `created_at`) VALUES
(6, 'image/uploads/Photos/2024101729913049.png', '2024-10-26 03:24:09');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `is_highlight` enum('Y','N') NOT NULL DEFAULT 'N',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `body`, `is_highlight`, `created_at`, `updated_at`, `deleted_at`, `view_count`, `category`) VALUES
(1, 3, 'Top 10 Platforms to Practice Python', '<p style=\"margin-bottom: 26px; overflow-wrap: break-word; font-family: Verdana, BlinkMacSystemFont, -apple-system, &quot;segoe ui&quot;, Roboto, Oxygen, Ubuntu, Cantarell, &quot;open sans&quot;, &quot;helvetica neue&quot;, sans-serif; font-size: 15px;\">Python is a high-level, flexible programming language that is well-known for its extensive ecosystem, ease of use, and readability. Python’s vast libraries and frameworks offer advanced capabilities for seasoned developers, and its simple syntax and readability make it a good language. Numerous domains, such as web development, data research, machine learning, automation, and scientific computing, heavily rely on Python. Because of its versatility, it can handle challenging jobs like developing reliable online apps, evaluating enormous datasets, developing predictive models, and even automating repetitive chores.</p><p style=\"margin-bottom: 26px; overflow-wrap: break-word; font-family: Verdana, BlinkMacSystemFont, -apple-system, &quot;segoe ui&quot;, Roboto, Oxygen, Ubuntu, Cantarell, &quot;open sans&quot;, &quot;helvetica neue&quot;, sans-serif; font-size: 15px;\">Numerous platforms are available to support Python’s popular applications. These platforms include planned exercises, real-world problems, and interactive experiences to help both beginners and specialists learn the principles and specialized abilities of Python. The top ten platforms are as follows.</p>', 'Y', '2024-12-07 11:02:42', NULL, NULL, 0, 'artikel'),
(2, 3, 'This AI Paper from UCLA Unveils ‘2-Factor Retrieval’ for Revolutionizing Human-AI Decision-Making in Radiology', '<p style=\"margin-bottom: 26px; overflow-wrap: break-word; font-family: Verdana, BlinkMacSystemFont, -apple-system, &quot;segoe ui&quot;, Roboto, Oxygen, Ubuntu, Cantarell, &quot;open sans&quot;, &quot;helvetica neue&quot;, sans-serif; font-size: 15px;\">Integration of AI into clinical practices is very challenging, especially in radiology. While AI has proven to enhance the accuracy of diagnosis, its “black-box” nature often erodes clinicians’ confidence and acceptance. Current clinical decision support systems (CDSSs) are either not explainable or use methods like saliency maps and Shapley values, which do not give clinicians a reliable way to verify AI-generated predictions independently. This lack is significant, as it limits the potential of AI in medical diagnosis and increases the dangers involved with overreliance on potentially wrong AI output. To address this requires new solutions that will close the trust deficit and arm health professionals with the right tools to assess the quality of AI decisions in demanding environments like health care.</p><p style=\"margin-bottom: 26px; overflow-wrap: break-word; font-family: Verdana, BlinkMacSystemFont, -apple-system, &quot;segoe ui&quot;, Roboto, Oxygen, Ubuntu, Cantarell, &quot;open sans&quot;, &quot;helvetica neue&quot;, sans-serif; font-size: 15px;\">Explainability techniques in medical AI, such as saliency maps, counterfactual reasoning, and nearest-neighbor explanations, have been developed to make AI outputs more interpretable. The main goal of the techniques is to explain how AI predicts, thus arming clinicians with useful information to understand the decision-making process behind the predictions. However, limitations exist. One of the greatest challenges is overreliance on the AI. Clinicians often are swayed by potentially convincing but incorrect explanations presented by the AI.</p>', 'N', '2024-12-07 12:30:42', NULL, NULL, 0, 'artikel'),
(3, 3, 'How to Transform an Angular Application with Signals', '<p style=\"box-sizing: inherit; margin-bottom: 1.5em; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: 1.5em; font-family: Lato, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-size: 1.25em; vertical-align: baseline; min-width: 100%; color: rgb(10, 10, 35);\">complex enterprise applications. It is widely used by large companies. Therefore, having the skills to build a performant application using Angular is one of the top skills for a developer..</p><p style=\"box-sizing: inherit; margin-bottom: 1.5em; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-family: Lato, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-size: 22px; vertical-align: baseline; min-width: 100%; color: rgb(10, 10, 35);\">Angular\'s rise to fame can be attributed to a special feature called reactivity. Reactivity is the ability of the framework to change the user interface (UI) when underlying data or state of the application changes.</p><p style=\"box-sizing: inherit; margin-bottom: 1.5em; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-family: Lato, sans-serif; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; font-size: 22px; vertical-align: baseline; min-width: 100%; color: rgb(10, 10, 35);\">This change can be due to asynchronous events like getting response from an API call, or from a user action such as clicking a button. To achieve this reactivity, Angular deploys a mechanism called change detection. Reactivity is a double-edged sword though, and can often lead to performance issues due to unwanted updates to UI.</p>', 'N', '2024-12-07 12:38:15', '2024-12-07 12:38:51', NULL, 0, 'artikel'),
(4, 3, 'Introduction to Zod for Data Validation', '<p><span style=\"color: rgb(25, 25, 38); font-family: __Montserrat_47416d, __Montserrat_Fallback_47416d, sans-serif; font-size: 18px; background-color: rgb(247, 247, 247);\">As web developers, we\'re often working with data from external sources like APIs we don\'t control or user inputs submitted to our backends. We can\'t always rely on this data to take the form we expect, and we can encounter unexpected errors when it deviates from expectations. But with the&nbsp;</span><a href=\"https://zod.dev/\" style=\"margin: 0px; padding: 0px; color: rgb(220, 57, 39); overflow-wrap: break-word; font-family: __Montserrat_47416d, __Montserrat_Fallback_47416d, sans-serif; font-size: 18px; background-color: rgb(247, 247, 247);\">Zod</a><span style=\"color: rgb(25, 25, 38); font-family: __Montserrat_47416d, __Montserrat_Fallback_47416d, sans-serif; font-size: 18px; background-color: rgb(247, 247, 247);\">&nbsp;library, we can define what our data ought to look like and parse the incoming data against those defined schemas. This lets us work with that data confidently, or to quickly throw an error when it isn\'t correct.</span></p>', 'N', '2024-12-07 12:44:10', NULL, NULL, 0, 'artikel'),
(5, 3, 'User feedback and analytics', '<p><span style=\"font-size: 8.8px;\">Formbricks is an open-source tool for collecting user feedback and form analytics.</span></p><p><span style=\"font-size: 8.8px;\">It helps devs understand user behavior, allowing them to improve performance, reduce friction, and enhance the overall UX.</span></p><p><span style=\"font-size: 8.8px;\">Formbricks is an open-source tool for collecting user feedback and form analytics.</span></p><p><span style=\"font-size: 8.8px;\">It helps devs understand user behavior, allowing them to improve performance, reduce friction, and enhance the overall UX.</span></p><p><span style=\"font-size: 8.8px;\">Formbricks is an open-source tool for collecting user feedback and form analytics.</span></p><p><span style=\"font-size: 8.8px;\">It helps devs understand user behavior, allowing them to improve performance, reduce friction, and enhance the overall UX.</span></p><p><span style=\"font-size: 8.8px;\">Formbricks is an open-source tool for collecting user feedback and form analytics.</span></p><p><span style=\"font-size: 8.8px;\">It helps devs understand user behavior, allowing them to improve performance, reduce friction, and enhance the overall UX.</span></p><p><span style=\"font-size: 8.8px;\">Formbricks is an open-source tool for collecting user feedback and form analytics.</span></p><p><span style=\"font-size: 8.8px;\">It helps devs understand user behavior, allowing them to improve performance, reduce friction, and enhance the overall UX.</span></p>', 'N', '2024-12-07 12:45:23', NULL, NULL, 0, 'artikel'),
(6, 3, 'Jest Setup: Gotchas with Next and MUI', '<p><span style=\"font-size: 8.8px;\">The documentation on setting up UI tests with Jest and React Testing Library is more than sufficient to get you going. However, when it’s used in a combination of NextJS and Material UI (an open-source React component library that implements Google’s Material Design), there are a few gotchas worth mentioning.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">TransformIgnorePatterns – NextJS gotcha</span></p><p><span style=\"font-size: 8.8px;\">SyntaxError: Cannot use import statement outside a module</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">One of the most frequent and early errors you might encounter when running the tests with the JavaScript testing framework Jest is related to module imports. A quick search for the top error will yield results in adding some transformIgnorePatterns. However, NextJS with its own nextJest() config will override this field with its own default configs. Therefore, the ideal place to put the transform patterns is after the config has been created. Here is a config with the usual needs.</span></p>', 'N', '2024-12-07 12:48:04', NULL, NULL, 0, 'artikel'),
(7, 3, 'Sejarah Awal Mula Wakaf', '<p><span style=\"font-size: 8.8px;\">LITERASI WAKAF – Dalam sejarah Islam, wakaf dikenal sejak masa Rasulullah SAW karena wakaf disyariatkan setelah Nabi hijrah ke Madinah pada tahun kedua Hijriyah. Ada dua pendapat yang berkembang di kalangan ahli yurisprudensi Islam (fuqaha) tentang siapa yang pertama kali melaksanakan syariat wakaf. Menurut sebagian ulama, yang pertama kali melaksanakan wakaf adalah Rasulullah SAW, yakni mewakafkan tanah milik Nabi SAW untuk dibangun masjid.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Pendapat ini berdasarkan hadis yang diriwayatkan oleh Umar bin Syabah dari Amr bin Sa’ad bin Mu’ad, dan diriwayatkan dari Umar bin Syabah, dari Umar bin Sa’ad bin Muad berkata, Kami bertanya tentang mula-mula wakaf dalam Islam? Orang Muhajirin menga takan adalah wakaf Umar, sedangkan orang- orang Ansor mengatakan adalah wakaf Rasulullah SAW.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Pendapat sebagian ulama yang mengatakan bahwa Sayyidina Umar adalah orang pertama yang melaksanakan syariat wakaf berdasar pada hadis yang diriwayatkan Ibnu Umar yang berkata, Bahwa sahabat Umar RA, memperoleh sebidang tanah di Khaibar, kemudian Umar RA, menghadap Rasulullah SAW untuk meminta petunjuk, umar berkata: ‘Hai Rasulullah SAW, saya mendapat sebi dang tanah di Khaibar, saya belum mendapat harta sebaik itu, maka apakah yang engkau perintahkan kepadaku?’ Rasulullah SAW bersabda: Bila engkau suka, kau tahan (pokoknya) tanah itu, dan engkau sedekahkan (hasilnya), tidak dijual, tidak dihibah kan, dan tidak diwariskan.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Ibnu Umar berkata lagi: Umar menyedekahkannya (hasil pengelolaan tanah) kepada orang-orang fakir, kaum kerabat, hamba sahaya, sabilillah Ibnu sabil, dan tamu, dan tidak dilarang bagi yang mengelola (nazhir) wakaf makan dari hasilnya dengan cara yang baik (sepantasnya) atau member makan orang lain dengan tidak bermaksud menumpuk harta.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Selain Umar, Rasulullah juga mewakafkan tujuh kebun kurma di Madinah di antaranya ialah kebun A’raf Shafiyah, Dalal, Barqah, dan lainnya. Nabi juga mewakafkan perkebunan Mukhairik, yang telah menjadi milik beliau setelah terbunuhnya Mukhairik ketika Perang Uhud. Beliau menyisihkan sebagian keuntungan dari perkebunan itu untuk member nafkah keluarganya selama satu tahun, sedangkan sisanya untuk membeli kuda perang, senjata dan untuk kepentingan kaum Muslimin. Mayoritas ahli fikih mengatakan bahwa peristiwa ini disebut wakaf.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Penulis: Taufik Hidayat</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Editor&nbsp; &nbsp; : Khayun Ahmad</span></p>', 'N', '2024-12-13 07:22:58', NULL, NULL, 0, 'Wakaf'),
(8, 3, 'Kisah Inspirasi Abu Thalhah Wakaf Kebun Bairahu Abu', '<p><span style=\"font-size: 8.8px;\">Dikisahkan, Abu Thalhah (Zaid bin Sahl) seorang sahabat dari kalangan Anshar yang memiliki kebun bernama Bairuha’ yang terletak tidak jauh dari Masjid Madinah, sebagai harta paling dicintai dan dibanggakannya.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Suatu waktu, Rasulullah SAW biasa masuk ke dalamnya dan berteduh di sana serta minum dari airnya. Tak lama setelah kejadian itu turun ayat Alquran yang berbunyi:</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">“Sekali-kali kamu tidak sampai pada kebaikan (yang sempurna) sebelum kamu menafkahkan sebagian harta yang kamu cintai.” (Ali Imran: 92).</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Setelah ayat diatas sampai ke telinga Abu Thalhah (Zaid bin Sahl). Kemudian, Ia bergegas mendatangi Rasulullah SAW dan berkata, “Aku ingin mengamalkan apa yang diperintahkan Allah untuk menyedekahkan apa yang kita cintai, wahai Rasulullah. Dengan harapan mendapatkan kebaikan sekaligus sebagai simpanan di sisi Allah. Maka ambillah dan letakkan ia di tempat yang pantas menurutmu. Terimalah kebun Bairuha’, satu-satunya harta yang aku miliki, sebagai sedekah. Aku serahkan kepada Anda untuk dibagi-bagikan kepada orang yang mem butuhkan.”</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Dengan gembira dan penuh sukacita, Rasulullah menyambut sedekah itu dan menguasakan teknis pembagian kebun itu kepada Abu Thalhah sendiri dan sambil berkata, ”Inilah harta yang diberkahi. Aku telah mendengar apa yang kau ucapkan dan aku menerimanya. Aku kembalikan lagi kepadamu dan berikanlah ia kepada kerabat-kerabat terdekatmu.”</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Rasulullah hanya menyarankan agar harta itu dibagikan kepada keluarga Abu Thalhah yang terdekat dan sangat membutuhkan terlebih dulu, baru kepada orang lain.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Selain itu, Abu Thalhah juga memberikan bagian kepada Rasulullah. Kemudian Rasulullah memberikan bagiannya tersebut kepada seorang penyair, Hassan bin Tsabit al-Anshari.&nbsp; Serta di antara orang yang menerima lainnya adalah Zaid bin Tsabit dan Ubay bin Ka’ab.</span></p>', 'N', '2024-12-13 07:44:20', NULL, NULL, 0, 'Sejarah Wakaf'),
(9, 3, 'Tata Cara Berwakaf Tanah', '<p><span style=\"font-size: 8.8px;\">Tata cara berwakaf tanah sebagai berikut:</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Wakif atau kuasanya datang menghadap Kepala Kantor Urusan Agama (KUA) selaku pejabat pembuat akta ikrar wakaf (PPAIW) dengan membawa:</span></p><p><span style=\"font-size: 8.8px;\">dokumen asli kepemilikan tanah;</span></p><p><span style=\"font-size: 8.8px;\">surat keterangan tidak dalam sengketa/perkara, tidak terbebani segala jenis sitaan, atau tidak dijaminkan dari instansi yang berwenang;</span></p><p><span style=\"font-size: 8.8px;\">nama dan identitas diri (KTP) wakif, nazhir, dan saksi</span></p><p><span style=\"font-size: 8.8px;\">Wakif atau kuasanya mengucapkan ikrar wakaf kepada nazhir dengan disaksikan oleh dua orang saksi di hadapan pejabat pembuat akta ikrar wakaf tanah, yaitu kepala KUA.</span></p><p><span style=\"font-size: 8.8px;\">PPAIW menerbitkan akta ikrar wakaf (AIW) rangkap 7 (tujuh) untuk disampaikan kepada:</span></p><p><span style=\"font-size: 8.8px;\">Wakif,</span></p><p><span style=\"font-size: 8.8px;\">Nazhir,</span></p><p><span style=\"font-size: 8.8px;\">Mauquf alaih,</span></p><p><span style=\"font-size: 8.8px;\">Kepala Kantor Kementerian Agama Kabupaten/Kota,</span></p><p><span style=\"font-size: 8.8px;\">Kantor Pertanahan Kabupaten/Kota</span></p><p><span style=\"font-size: 8.8px;\">Badan Wakaf Indonesia, dan</span></p><p><span style=\"font-size: 8.8px;\">Instansi berwenang lainnya.</span></p><p><span style=\"font-size: 8.8px;\">PPAIW menerbitkan surat pengesahan nazhir.</span></p><p><span style=\"font-size: 8.8px;\">PPAIW atau Nazhir mengajukan pendaftaran nazhir kepada Badan Wakaf Indonesia.</span></p><p><span style=\"font-size: 8.8px;\">PPAIW atau nazhir mendaftarkan tanah wakaf kepada Kantor Pertanahan Kabupaten/Kota.</span></p>', 'N', '2024-12-13 07:47:31', NULL, NULL, 0, 'Wakaf Tanah'),
(10, 3, 'Wakaf Uang di Indonesia', '<p><span style=\"font-size: 8.8px;\">LITERASI WAKAF – Wakaf uang di Indonesia mulai dikenal sejak dikeluarkannya fatwa wakaf uang oleh DSN MUI pada 2012.&nbsp; Fatwa itu berisi lima point penting. Pertama, Wakaf Uang (Cash Wakaf/Wagf al-Nuqud) adalah wakaf yang dilakukan seseorang, kelompok orang, lembaga atau badan hukum dalam bentuk uang tunai. Kedua, termasuk ke pengertian uang adalah surat-surat berharga. Ketiga, wakaf uang hukumnya jawaz (boleh), sedangkan keempat, wakaf uang hanya boleh disalurkan dan digunakan untuk hal-hal yang dibolehkan secara syar’i dan kelima, nilai pokok Wakaf Uang harus dijamin kelestariannya, tidak boleh dijual, dihibahkan, dan atau diwariskan.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Di Bangladesh, wakaf uang mulai dikenal tahun 1998.&nbsp; M.A. Mannan orang yang pertama kali mengenalkannya melalui SIBL (Social Islamic Bank Limited).&nbsp; SIBL mengeluarkan sertifikat wakaf uang yang pertama dalam sejarah perbankan.&nbsp; Wakif mendepositokan uangnya ke rekening wakaf uang.&nbsp; Lalu, bank mengelola uang yang didepositokan tersebut atas nama wakif.&nbsp; Hasil pengelolaan tersebut akan diberikan kepada mauquf alaih.&nbsp; Tidak heran kalau SIBL juga memiliki rumah sakit yang dikelola dari hasil wakaf uangnya.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Di Turki, wakaf uang mulai dikenal abad ke 15 Masehi.&nbsp; Sejak 400 tahun yang lalu , praktik wakaf uang ini telah menjadi trend di kalangan masyarakat.&nbsp; Pengadilan Ottoman telah menyetujui praktek waqaf uang pada abad ke 15.&nbsp; Jenis wakaf ini kemudian menjadi sangat populer pada abad ke 16 di seluruh Anatolia dan daratan Eropa dari kerajaan Ottoman, Turki.&nbsp; Pada zaman Ottoman, waqaf uang ini dipraktekkan hampir 300 tahun, dimulai dari tahun 1555-1823 M.&nbsp; Lebih dari 20 persen waqaf uang di Kota Bursa, selatan Istanbul, telah bertahan lebih dari seratus tahun.&nbsp; Dalam pengelolaannya, hanya 19 persen waqaf uang yang tidak bertambah, sementara 81 persen mengalami pertambahan (akumulasi) modal.&nbsp; Pada bulan safar, 1513 M, Elhac Sulaymen mewaqafkan 70.000 dirham perak.&nbsp; 40.000 dirham digunakan untuk membangun sekolah, dan 30.000 dirham lagi digunakan untuk pembiayaan murabahah.&nbsp; Hasil investasi murabahah ini, digunakan untuk membayar gaji guru sebesar 3 dirham per hari, asisten 1 dirham, qori pembaca Al-qur’an 1 dirham, dan nazir, pengelola waqaf, 2 dirham setiap harinya.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Di dunia, wakaf uang pertama sekali dikenalkan oleh Imam Al Zuhri (wafat 124 H).&nbsp; Beliau mengatakan bahwa mewakafkan dinar hukumnya boleh, dengan cara menjadikan dinar tersebut sebagai modal usaha kemudian keuntungannya disalurkan pada mauquf ‘alaih.&nbsp; Dengan semangat ini, maka wakaf sejatinya adalah produktif dan berfungsi sebagai sumber dana pembangunan ekonomi.&nbsp; Oleh karena itu, dalam UU no. 41 tahun 2004 tentang wakaf, diakui keberadaan wakaf uang di Indonesia.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Dalam peraturan BWI no. 1 tahun 2020 tentang pedoman pengelolaan dan pengembangan harta benda wakaf, diatur lagi tentang wakaf uang agar lebih memberikan manfaat sebesar besarnya bagi ekonomi mulai pasal 5 sampai pasal 19.&nbsp; Dalam pasal 12 ayat 1 dijelaskan bahwa nazir wajib membedakan pengelolaan antara wakaf uang untuk jangka waktu tertentu dengan wakaf uang untuk waktu selamanya.&nbsp; Wakaf uang untuk jangka waktu tertentu contohnya adalah Cash waqf linked sukuk, Kalisa dan akbari.</span></p>', 'N', '2024-12-13 07:48:21', NULL, NULL, 0, 'Wakaf Uang'),
(11, 3, 'Persyaratan Pendaftaran Nazhir Wakaf Uang', '<p><span style=\"font-size: 8.8px;\">LITERASI WAKAF – Berdasarkan Undang-Undang Nomor 41 Tahun 2004. Wakaf adalah perbuatan hukum orang yang berwakaf (Wakif) untuk menyerahkan sebagian harta benda miliknya untuk dimanfaatkan selamanya atau untuk jangka waktu tertentu sesuai dengan kepentingannya guna keperluan ibadah atau kesejahteraan umum menurut syariah melalui pengelola (Nazhir).</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Sedangkan definisi resmi Nazhir adalah pihak yang menerima harta benda wakaf dari orang yang berwakaf (wakif) untuk dikelola dan dikembangkan sesuai dengan peruntukannya.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Baca Juga: Daftar Nazhir Wakaf Uang – Update Oktober 2019</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Jenis wakaf itu bermacam-macam. Salah satunya adalah Wakaf Uang. Yang dimaksud Wakaf Uang adalah wakaf berupa uang dalam bentuk rupiah yang dapat dikelola secara produktif, hasilnya dimanfaatkan untuk penerima (Mauquf ‘Alaih).</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Dalam Undang-Undang Nomor 41 Tahun 2004 Tentang Wakaf, calon Nazhir Wakaf Uang wajib mendaftarkan diri kepada BWI dengan memenuhi persyaratan sebagai Nazhir sesuai peraturan dari Badan Wakaf Indonesia Nomor 2 Tahun 2010 Tentang Tata Cara Pendaftaran Nazhir Wakaf Uang.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Baca Juga: Peraturan Badan Wakaf Indonesia.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Berikut Ini Berkas Persyaratan Pendaftaran Nazhir Wakaf Uang di Badan Wakaf Indonesia:</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Surat permohonan Nazhir wakaf uang dari ketua badan hukum yang ditujukan kepada Ketua Badan Wakaf Indonesia (BWI)</span></p><p><span style=\"font-size: 8.8px;\">Struktur kepengurusan badan hukum dan struktur lembaga wakaf</span></p><p><span style=\"font-size: 8.8px;\">Daftar riwayat hidup dan photocopy kartu tanda pengenal (KTP) pengurus badan hukum dan lembaga wakaf</span></p><p><span style=\"font-size: 8.8px;\">Legalitas badan hukum (Akta Notaris dan Pengesahan Kemenkumham)</span></p><p><span style=\"font-size: 8.8px;\">Surat keterangan domisili badan hukum dari kelurahan</span></p><p><span style=\"font-size: 8.8px;\">Profil yayasan/lembaga, daftar inventaris harta wakaf yang dikelola, laporan pengelolaannya, hasil pengelolaannya dan penyaluran hasilnya ke penerima (Mauquf ‘Alaih) dalam bentuk laporan keuangan.</span></p><p><span style=\"font-size: 8.8px;\">Rencana kerja penghimpunan, pengelolaan/ pengembangan wakaf uang, dan penyaluran hasil wakaf</span></p><p><span style=\"font-size: 8.8px;\">Memiliki biaya operasional minimal 30 juta</span></p><p><span style=\"font-size: 8.8px;\">Rekomendasi Lembaga Keuangan Syariah Penerima Wakaf Uang (LKS-PWU)</span></p><p><span style=\"font-size: 8.8px;\">Surat pernyataan bersedia memberikan laporan pelaksanaan tugas/laporan wakaf bermaterai ditandatangani oleh Ketua badan hukum</span></p><p><span style=\"font-size: 8.8px;\">Surat pernyataan bersedia diaudit oleh BWI atau oleh akuntan publik yang ditunjuk oleh BWI bermaterai ditandatangani oleh Ketua badan hukum.</span></p>', 'N', '2024-12-13 07:49:28', NULL, NULL, 0, 'Nazhir'),
(12, 3, 'Peraturan BWI No. 1 Tahun 2021 Tentang Organisasi dan Tata Kerja BWI', '<p><span style=\"font-size: 8.8px;\">LITERASI WAKAF – Seiring perkembangan wakaf di Indonesia yang ditandai dengan Gerakan perwakafan Nasional yang baru-baru ini diluncurkan Gerakan Nasional Wakaf Uang oleh Presiden Republik Indonesia, Badan Wakaf Indonesia mengeluarkan Peraturan Badan Wakaf Indonesia No. 1 Tahun 2021 tentang Organisasi dan Tata Kerja Badan Wakaf Indonesia.</span></p><p><span style=\"font-size: 8.8px;\">LITERASI WAKAF – Seiring perkembangan wakaf di Indonesia yang ditandai dengan Gerakan perwakafan Nasional yang baru-baru ini diluncurkan Gerakan Nasional Wakaf Uang oleh Presiden Republik Indonesia, Badan Wakaf Indonesia mengeluarkan Peraturan Badan Wakaf Indonesia No. 1 Tahun 2021 tentang Organisasi dan Tata Kerja Badan Wakaf Indonesia.</span></p><p><span style=\"font-size: 8.8px;\">LITERASI WAKAF – Seiring perkembangan wakaf di Indonesia yang ditandai dengan Gerakan perwakafan Nasional yang baru-baru ini diluncurkan Gerakan Nasional Wakaf Uang oleh Presiden Republik Indonesia, Badan Wakaf Indonesia mengeluarkan Peraturan Badan Wakaf Indonesia No. 1 Tahun 2021 tentang Organisasi dan Tata Kerja Badan Wakaf Indonesia.</span></p><p><span style=\"font-size: 8.8px;\">LITERASI WAKAF – Seiring perkembangan wakaf di Indonesia yang ditandai dengan Gerakan perwakafan Nasional yang baru-baru ini diluncurkan Gerakan Nasional Wakaf Uang oleh Presiden Republik Indonesia, Badan Wakaf Indonesia mengeluarkan Peraturan Badan Wakaf Indonesia No. 1 Tahun 2021 tentang Organisasi dan Tata Kerja Badan Wakaf Indonesia.</span></p><div><br></div>', 'N', '2024-12-13 07:55:32', NULL, NULL, 0, 'Regulasi Wakaf'),
(13, 3, 'Materi Talkshow Research Expose Seri 6', '<p><span style=\"font-size: 8.8px;\">LITERASI WAKAF – Talkshow Research Expose Seri 6 akan dilaksanakan pada Jumat, 25 Juni 2021 dan menghadirkan dua orang peneliti wakaf dari IAIN Kudus dan Universitas Brawijaya.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Jadzil Baihaqi, M.S.A. dari IAIN Kudus akan memaparkan penelitian yang berjudul “Penerapan PSAK 112 dalam wakaf uang dan saham”.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Sementara Girindra Mega Paksi, S.E., M.E. dari Universitas Brawijaya akan mengupas hasil risetnya yang berjudul “Wakaf Saham sebagai Investasi Dunia Akhirat”.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Apa saja temuan dan implikasi dari kedua riset tersebut? Ikuti pembahasannya yang akan dipandu oleh Dr. Hendri Tanjung (Anggota BWI) pada: 🗓️ Jumat, 9 Juli 2021 🕗 Pukul 16.00-17.00 WIB.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Berikut Materi Talkshow Research Expose Seri 6:</span></p>', 'N', '2024-12-13 07:56:31', NULL, NULL, 0, 'Materi Wakaf'),
(14, 3, 'Indeks Wakaf Nasional 2021', '<p><span style=\"font-size: 8.8px;\">Permasalahan wakaf di Indonesia tidak hanya terkait persepsi masyarakat terhadap wakaf ataupun minimnya dukungan dari pemerintah tetapi juga kurangnya kepercayaan masyarakat terhadap lembaga wakaf profesionalisme pengelola wakaf/nazhir (Huda et al., 2017) serta tidak adanya data terintegrasi terkait wakaf yang menunjukkan perkembangan kinerja wakaf di Indonesia. Sehingga, perlu adanya pengukuran pengukuran kinerja wakaf sebagai sarana untuk meningkatkan kepedulian terhadap pengelolaan wakaf dan sebagai alat untuk memantau perkembangan wakaf (Siraj, 2012; Khalil, Ali dan Shaiban, 2014; Siswantoro, Rosdiana dan Fathurahman, 2017).</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Adanya Indeks Wakaf Nasional (IWN) yang telah diluncurkan pada tahun 2020 sebagai alat pengukuran terstandar dapat menjadi acuan kinerja wakaf nasional. Hasil yang didapat dari perhitungan indeks wakaf dapat digunakan untuk membandingkan hasil pengukuran setiap wilayah dari waktu ke waktu untuk menyiapkan rencana jangka panjang dalam pengelolaan wakaf di Indonesia.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Adanya pengukuran indeks wakaf yang terstandar dan dapat diterima di tingkat negara juga dapat menjadi alat otoritas wakaf untuk mengevaluasi dan memantau kondisi keseluruhan kegiatan wakaf di suatu negara serta meningkatkan pencatatan aset wakaf (Zain, Mahadi dan Noor, 2019), serta mencerminkan transparansi dan akuntabilitas pengelola wakaf secara keseluruhan di suatu negara (Noordin, Haron dan Kassim, 2017). Pada penyusunan Indeks Wakaf Nasional, kelengkapan indeks sangat penting dan harus memenuhi berbagai aspek seperti aspek pengelolaan wakaf, sistem pendukung, dan dampak wakaf bagi masyarakat ditambah aspek pencapaian agenda pembangunan. Hal tersebut diperlukan karena indeks kinerja wakaf tingkat negara dapat menjadi tolak ukur bagi seluruh mutawali untuk dipatuhi demi kemajuan pengelolaan wakaf dan menjadi media untuk menginformasikan kepada masyarakat tentang bagaimana wakaf telah berhasil bagi masyarakat dan sejauh mana potensi wakaf telah dimanfaatkan, yang pada akhirnya akan meningkatkan kesadaran masyarakat tentang wakaf. Sehingga agenda pembangunan wakaf dapat terpenuhi.</span></p><p><span style=\"font-size: 8.8px;\"><br></span></p><p><span style=\"font-size: 8.8px;\">Penelitian ini bertujuan untuk melakukan pengukuran indeks wakaf nasional (IWN) pada tingkat provinsi dan wilayah di Indonesia yang mana hasil pengukuran ini diharapkan dapat digunakan untuk pembuatan kebijakan wakaf mengingat dampaknya yang sangat besar bagi masyarakat.</span></p>', 'N', '2024-12-13 07:57:17', NULL, NULL, 0, 'Indeks Wakaf Nasional');

-- --------------------------------------------------------

--
-- Table structure for table `post_photos`
--

CREATE TABLE `post_photos` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `photo_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_photos`
--

INSERT INTO `post_photos` (`id`, `post_id`, `photo_url`) VALUES
(7, 1, 'image/uploads/Posts/1/1/2024121733572962.png'),
(8, 2, 'image/uploads/Posts/2/1/2024121733578242.png'),
(9, 3, 'image/uploads/Posts/3/1/2024121733578695.jpeg'),
(10, 4, 'image/uploads/Posts/4/1/2024121733579050.png'),
(11, 5, 'image/uploads/Posts/5/1/2024121733579123.png'),
(12, 6, 'image/uploads/Posts/6/1/2024121733579284.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `regulations`
--

CREATE TABLE `regulations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `attactment_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subdistricts`
--

CREATE TABLE `subdistricts` (
  `id` int(11) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subdistricts`
--

INSERT INTO `subdistricts` (`id`, `city_id`, `name`, `created_at`) VALUES
(1, 1, 'Cengkareng', '2024-12-07 13:01:14'),
(3, 2, 'Cilandak', '2024-12-07 13:02:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'admin', 'admin', 'e072486e56d87c83ca61a09dbb0cb1dc2b6709f9', '2024-10-22 12:56:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'big bos', 'boss', 'b570698f121df21dc685180fecc8e7b36f508e0f', '2024-10-26 08:15:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `villages`
--

CREATE TABLE `villages` (
  `id` int(11) NOT NULL,
  `subdistrict_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `villages`
--

INSERT INTO `villages` (`id`, `subdistrict_id`, `name`, `created_at`) VALUES
(1, NULL, NULL, '2024-11-03 06:54:56');

-- --------------------------------------------------------

--
-- Table structure for table `vision_misions`
--

CREATE TABLE `vision_misions` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `vision` varchar(255) DEFAULT NULL,
  `mission` varchar(255) DEFAULT NULL,
  `photo_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vision_misions`
--

INSERT INTO `vision_misions` (`id`, `title`, `vision`, `mission`, `photo_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'Terwujudnya Lembaga independent yang dipercaya masyarakat, mempunyai kemampuan dan integritas untuk mengembangkan perwakafan nasional dan internasional1', 'Menjadikan Badan Wakaf Indonesia sebagai Lembaga professional yang mampu mewujudkan potensi dan manfaat ekonomi harta benda wakaf untuk kepentingan ibadah dan pemberdayaan masyarakat', 6, '2024-10-26 03:10:22', '2024-10-26 03:24:09', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `wakaf_books`
--

CREATE TABLE `wakaf_books` (
  `id` int(11) NOT NULL,
  `wakaf_land_register_no` varchar(255) DEFAULT NULL,
  `book_no` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` enum('taken','returned') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wakaf_lands`
--

CREATE TABLE `wakaf_lands` (
  `id` int(11) NOT NULL,
  `register_no` varchar(255) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `subdistrict_id` int(11) DEFAULT NULL,
  `village_id` int(11) DEFAULT NULL,
  `area_size` double DEFAULT NULL,
  `used` varchar(255) DEFAULT NULL,
  `object_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `certificate_no` varchar(255) DEFAULT NULL,
  `certificate_date` varchar(255) DEFAULT NULL,
  `aiw_no` varchar(255) DEFAULT NULL,
  `aiw_date` varchar(255) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `wakif_name` varchar(255) DEFAULT NULL,
  `nadzir_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wakaf_lands`
--

INSERT INTO `wakaf_lands` (`id`, `register_no`, `city_id`, `subdistrict_id`, `village_id`, `area_size`, `used`, `object_name`, `address`, `status`, `certificate_no`, `certificate_date`, `aiw_no`, `aiw_date`, `latitude`, `longitude`, `wakif_name`, `nadzir_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, '31.73.06.1003.23', 2, 3, 0, 113, 'Sosial lainnya', 'YAYASAN BINA WARGA', 'Jl. Lingkungan III No.68 Rt/Rw. 007/03', 'Sertifikat', '1134/Wakaf', '35074', 'w3/06/01/c/ Tahun 1992', '26 Juni 1992', -6.175392, 106.827153, 'H. Suherman', 'KH. Abdul Hamid', '2024-12-09 12:41:12', '2024-12-09 12:41:12', '0000-00-00 00:00:00'),
(3, '31.73.06.1003.103', 2, 3, 0, 1356, 'Masjid', 'MASJID JAMI\' NURUL QOMAR', 'Jl. Kayu besar Rt/Rw. 003/012', 'Sertifikat', '1360/Wakaf', '35531', 'W3a/09/01/1990', '30 Juni 1990', -6.174392, 106.826153, 'H. Romli', 'KH. Syarifudin', '2024-12-09 12:41:12', '2024-12-09 12:41:12', '0000-00-00 00:00:00'),
(4, '31.73.06.1001.191', 2, 3, 0, 296, 'Masjid', 'MASJID JAMI\' AL-HUDA', 'Jl. Warung gantung Kp.rawa lele Rt/Rw. 05/010', 'Sertifikat', '1053/Wakaf', '35453', 'w3/01/c Tahun 1992', '08 Juni 1992', -6.173392, 106.825153, 'H. Marzuki', 'KH. Ahmad Dahlan', '2024-12-09 12:41:12', '2024-12-09 12:41:12', '0000-00-00 00:00:00'),
(5, '31.73.06.1004.342', 2, 3, 0, 132, 'Masjid', 'MASJID AL-BARKAH', 'Jl. Prepedan No. 1AB Rt/Rw. 05/07', 'Belum', '-', '-', 'w2/KK.09.4.6/WK/209/2009', '17 Juli 2009', -6.172392, 106.824153, 'H. Sofyan', 'KH. Abdullah', '2024-12-09 12:41:12', '2024-12-09 12:41:12', '0000-00-00 00:00:00'),
(6, '31.73.06.1002.13.2020', 2, 3, 0, 572, 'Masjid', 'MASJID JAMI\' KHOIRUL HUDA', 'Jl. Gaga Utama Rt/Rw. 005/009', 'Belum', '-', '-', 'w3/48/01/C/ Tahun 1992', '27 Februari 1992', -6.171392, 106.823153, 'H. Ridwan', 'KH. Mahmud', '2024-12-09 12:41:12', '2024-12-09 12:41:12', '0000-00-00 00:00:00'),
(7, '31.73.06.1005.493', 2, 3, 0, 27, 'Masjid', 'Masjid Jami\' Sirojul Huda', 'Jl. Tanjung Pura RT 004/08', 'Sertifikat', '1769i/Milik', '11 Januari 2019', 'W2/Kua.09.04/6/276.277 Tahun 2022', '12 Juli 2022', -6.170392, 106.822153, 'H. Saiful', 'KH. Zainudin', '2024-12-09 12:41:12', '2024-12-09 12:41:12', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `wakaf_land_photos`
--

CREATE TABLE `wakaf_land_photos` (
  `id` int(11) NOT NULL,
  `wakaf_land_id` int(11) DEFAULT NULL,
  `photo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner_photos`
--
ALTER TABLE `banner_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_profiles`
--
ALTER TABLE `company_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_profile_attachments`
--
ALTER TABLE `company_profile_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_profile_photos`
--
ALTER TABLE `company_profile_photos`
  ADD PRIMARY KEY (`id`);


--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_photos`
--
ALTER TABLE `post_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regulations`
--
ALTER TABLE `regulations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subdistricts`
--
ALTER TABLE `subdistricts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `villages`
--
ALTER TABLE `villages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vision_misions`
--
ALTER TABLE `vision_misions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wakaf_books`
--
ALTER TABLE `wakaf_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wakaf_lands`
--
ALTER TABLE `wakaf_lands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wakaf_land_photos`
--
ALTER TABLE `wakaf_land_photos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banner_photos`
--
ALTER TABLE `banner_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_profiles`
--
ALTER TABLE `company_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_profile_attachments`
--
ALTER TABLE `company_profile_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_profile_photos`
--
ALTER TABLE `company_profile_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `post_photos`
--
ALTER TABLE `post_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `regulations`
--
ALTER TABLE `regulations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subdistricts`
--
ALTER TABLE `subdistricts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `villages`
--
ALTER TABLE `villages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wakaf_books`
--
ALTER TABLE `wakaf_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wakaf_lands`
--
ALTER TABLE `wakaf_lands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wakaf_land_photos`
--
ALTER TABLE `wakaf_land_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
