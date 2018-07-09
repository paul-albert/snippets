# -*- coding: utf-8 -*-
from xml.dom.minidom import parseString
from langdetect import detect as language_detect
import pycountry


FILE_NAME_A = 'feed_a.xml'
FILE_NAME_B = 'feed_b.xml'
FILE_NAME_C = 'feed_c.xml'
DEFAULT_ENCODING = 'utf-8'


class BaseParser(object):

    def __init__(self, file_name):
        BaseParser.output(file_name)
        with open(file_name, 'r', encoding=DEFAULT_ENCODING) as f:
            self.file_content = f.read()
        self.job_tag_name, self.url_tag_name = '', ''

    def clear_text(self):
        self.file_content = self.file_content.replace('&nbsp;', ' ')

    def get_description(self, job):
        return ''

    def parse(self):
        self.clear_text()
        dom = parseString(self.file_content)
        jobs = dom.getElementsByTagName(self.job_tag_name)
        for job in jobs:
            url = BaseParser.get_text(
                job.getElementsByTagName(self.url_tag_name)[0]).strip()
            url = url.replace('&amp;', '&')
            description = self.get_description(job)
            language_code = language_detect(description)
            BaseParser.output('  job #{}:'.format(jobs.index(job) + 1))
            BaseParser.output('    url:      {}'.format(url))
            BaseParser.output('    language: {} ({})'.format(
                language_code, BaseParser.get_language_name(language_code)))

    @staticmethod
    def output(text):
        print(text)

    @staticmethod
    def get_text(node_list):
        return ''.join(node.data for node in node_list.childNodes
                       if node.nodeType == node.TEXT_NODE)

    @staticmethod
    def get_language_name(code):
        return pycountry.languages.get(alpha_2=code).name


class ParserA(BaseParser):

    def __init__(self, file_name):
        super(ParserA, self).__init__(file_name)
        self.job_tag_name, self.url_tag_name = 'job', 'url'

    def get_description(self, job):
        return BaseParser.get_text(
            job.getElementsByTagName('description')[0]).strip()


class ParserB(BaseParser):

    def __init__(self, file_name):
        super(ParserB, self).__init__(file_name)
        self.job_tag_name, self.url_tag_name = 'PositionOpening', 'InternetReference'

    def get_description(self, job):
        return job.getElementsByTagName('FormattedPositionDescription')[0].\
            childNodes[1].firstChild.nodeValue.strip()


class ParserC(BaseParser):

    def __init__(self, file_name):
        super(ParserC, self).__init__(file_name)
        self.job_tag_name, self.url_tag_name = 'stellenangebot', 'url'

    def get_description(self, job):
        return job.getElementsByTagName('candidate')[0].firstChild.nodeValue


def main():
    parser_a = ParserA(FILE_NAME_A)
    parser_a.parse()
    parser_b = ParserB(FILE_NAME_B)
    parser_b.parse()
    parser_c = ParserC(FILE_NAME_C)
    parser_c.parse()


if __name__ == '__main__':
    main()
