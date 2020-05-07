
--
-- Database: 'phplessons'
--

-- --------------------------------------------------------

create table labdetails(
 ID int not null auto_increment,
 Subject varchar(50) not null,
 LabName varchar(50) not null,
 Description varchar(100),
 LabInstructor varchar(50),
 primary key (ID)
);

Alter table labdetails add constraint unique_lab UNIQUE (Subject, LabName);





--
-- Table structure for table `docdetails`
--

CREATE TABLE IF NOT EXISTS docdetails(
  `Doc_ID` int(11) NOT NULL,
  `Subject` varchar(250) NOT NULL,
  `LabName` varchar(250) NOT NULL,
  `FileName` varchar(250) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `docdetails`
--
ALTER TABLE `docdetails`
  ADD PRIMARY KEY (`Doc_ID`);


ALTER TABLE `docdetails`
  MODIFY `Doc_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;