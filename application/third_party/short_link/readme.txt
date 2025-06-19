生成短链接，方便顾问在IM上发收款链接、收集客人链接等
--ycc 2023-02-03


-- DROP TABLE InfoManager.dbo.infoShortLinks;

CREATE TABLE InfoManager.dbo.infoShortLinks (
	isl_id int IDENTITY(0,1) NOT NULL,
	isl_link varchar(512) COLLATE Chinese_PRC_CI_AS NULL,
	isl_type varchar(125) COLLATE Chinese_PRC_CI_AS NULL,
	isl_URL nvarchar(2048) COLLATE Chinese_PRC_CI_AS NULL,
	isl_datetime smalldatetime DEFAULT getdate() NULL
);
 CREATE NONCLUSTERED INDEX infoShortLinks_isl_link_IDX ON dbo.infoShortLinks (  isl_link ASC  ) 