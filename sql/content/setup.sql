SET NAMES utf8;

DROP TABLE IF EXISTS blog;
CREATE TABLE blog
(
	`id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `path` CHAR(120) UNIQUE,
    `slug` CHAR(120) UNIQUE,
    `title` VARCHAR(120),
    `data` TEXT,
    `type` CHAR(20),
    `filter` VARCHAR(80) DEFAULT NULL,
    `published` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `deleted` DATETIME DEFAULT NULL
)
	ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci
;

INSERT INTO `blog` (`path`, `slug`, `type`, `title`, `data`, `filter`) VALUES
	("test-bbcode", null, "page", "Test BBCode", "Den här texten är skriven i [url=http://en.wikipedia.org/wiki/BBCode]bbcode[/url] vilket innebär att man kan formattera texten till [b]bold[/b] och [i]kursiv stil[/i] samt hantera länkar.\n\nDessutom finns ett filter 'nl2br' som lägger in <br>-element istället för \\n, det är smidigt, man kan skriva texten precis som man tänker sig att den skall visas, med radbrytningar.", "esc,bbcode,nl2br"),
	("test-bbcode-utan-filter", null, "page", "Test BBCode utan filter", "Den här texten är skriven i [url=http://en.wikipedia.org/wiki/BBCode]bbcode[/url] vilket innebär att man kan formattera texten till [b]bold[/b] och [i]kursiv stil[/i] samt hantera länkar.\n\nDessutom finns ett filter 'nl2br' som lägger in <br>-element istället för \\n, det är smidigt, man kan skriva texten precis som man tänker sig att den skall visas, med radbrytningar. I det här testfallet har dock inget filter lagts på.", null),
	("test-markdown", null, "page", "Test markdown", "Den här texten är skriven i [Markdown](http://en.wikipedia.org/wiki/Markdown). Markdown innebär att du får bra kontroll över innehållet i din sida, du kan formattera och sätta rubriker, men du behöver inte bry dig om HTML.\n\nRubrik nivå 2\n-------------\n\nDu skriver enkla styrtecken för att formattera texten som **fetstil** och *kursiv*. Det finns ett speciellt sätt att länka, skapa tabeller och så vidare.\n\n###Rubrik nivå 3\n\nNär man skriver i markdown så blir det läsbart även som textfil och det är lite av tanken med markdown.", "markdown"),
	("test-markdown-utan-filter", null, "page", "Test markdown utan filter", "Den här texten är skriven i [Markdown](http://en.wikipedia.org/wiki/Markdown), men mardown-filtret har inte applicerats. Markdown innebär att du får bra kontroll över innehållet i din sida, du kan formattera och sätta rubriker, men du behöver inte bry dig om HTML.\n\nRubrik nivå 2\n-------------\n\nDu skriver enkla styrtecken för att formattera texten som **fetstil** och *kursiv*. Det finns ett speciellt sätt att länka, skapa tabeller och så vidare.\n\n###Rubrik nivå 3\n\nNär man skriver i markdown så blir det läsbart även som textfil och det är lite av tanken med markdown.", null),
	("test-makeclickable", null, "page", "Test MakeClickable", "Test av filter som gör att när det finns länkar till andra webbplatser så kommer de länkarna att bli klickbara.\n\nhttp://dbwebb.se är ett exempel på en länk som blir klickbar.", "link,nl2br"),
	("test-makeclickable-utan-filter", null, "page", "Test MakeClickable utan filter", "Test av texten för MakeClickable utan filter som gör att när det finns länkar till andra webbplatser så kommer de länkarna att bli klickbara.\n\nhttp://dbwebb.se är ett exempel på en länk som blir klickbar.", null),
	("test-blog-post", null, "post", "Test av Blogpost", "Test så att det fungerar med blogposter och inte bara sidor", "nl2br"),
	(null, "test-slug", "post", "Test av slug", "Test så att slug fungerar om path saknas", "nl2br")
;