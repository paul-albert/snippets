# Model for articles_categories entity

from sqlalchemy import Column, ForeignKey
from sqlalchemy.orm import relationship
from sqlalchemy.types import Integer

from . import db, MixinModel


class ArticleCategory(db.Model, MixinModel):
    """
    Model for ArticleCategory.
    
    (Mapping between articles and categories)
    """
    __tablename__ = 'articles_categories'

    article_id = Column(Integer,
                        ForeignKey('articles.id'),
                        primary_key=True)
    category_id = Column(Integer,
                         ForeignKey('categories.id'),
                         primary_key=True)

    articles = relationship('Article',
                            backref='articles')
    categories = relationship('Category',
                              backref='categories')

    def get_articles(self):
        """
        Get articles for given row of ArticleCategory.
        
        :return: articles list
        :rtype:  list
        """
        return \
            [a.to_dict() for a in self.articles] if self.id is not None \
            else []

    def get_categories(self):
        """
        Get categories for given row of ArticleCategory.

        :return: categories list
        :rtype:  list
        """
        return \
            [c.to_dict() for c in self.categories] if self.id is not None \
            else []
