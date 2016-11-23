A simple crawler
===================

Many years ago, I always want to get my interesting data from another web site.
And I tried to using crawler or data mining tools which are open source.

I try to code a PHP tool to get data from a site.

## steps

1. Get a domain-name, which is simple;

2. Using wget tool which is a UNIX tool and if you want to use it under windows, install cygwin
3. Get your interesting pages and content and save them on your local system.

```shell
mkdir domain-name && cd domain-name
$wget -m -k --page-requisites -H --tries=0 -b -o wget.log --continue --domains=domain-name.com  www.domain-name.com
```

4. Coding & find data & filter them & inject to database.

```shell
git clone 
```

that's all. enjoy it.