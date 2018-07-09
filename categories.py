# Categories controller

from flask import jsonify, make_response, request
from flask_api import status

from models import Category, db, DatabaseException
from . import controllers


@controllers.route('/categories/', methods=['GET'])
def get_categories():
    """
    Get all categories info. (R in CRUD pattern)

    :return: response with info
    :rtype:  flask.wrappers.Response
    """
    categories = [{'category': c.to_dict(),
                   'categories_articles': c.get_categories_articles()}
                   for c in Category.query.order_by(Category.id).all()]
    # additionally we do query for parent categories names
    for category in categories:
        if category['category']['parent_id'] is not None:
            category['category']['parent_name'] = Category.query.get(category['category']['parent_id']).name
        else:
            category['category']['parent_name'] = ''
    response_status = status.HTTP_200_OK
    return make_response(jsonify({
        'categories': categories,
    }), response_status)


@controllers.route('/categories/<int:id>', methods=['GET'])
def get_category(id):
    """
    Get category's info by its id. (R in CRUD pattern)

    :param id: category id
    :type  id: int

    :return: response with info
    :rtype:  flask.wrappers.Response
    """
    category = Category.query.get(id)
    response = {
        'category': category.to_dict() if category is not None else None,
        'categories_articles': category.get_categories_articles() if category is not None else []
    }
    response_status = status.HTTP_200_OK
    return make_response(jsonify(
        response
    ), response_status)


@controllers.route('/categories/<int:id>', methods=['DELETE'])
def delete_category(id):
    """
    Delete category by its id. (D in CRUD pattern)

    :param id: category id
    :type  id: int

    :return: response with info
    :rtype:  flask.wrappers.Response
    """
    category = Category.query.get(id)
    if category is not None:
        try:
            db.session.delete(category)
            db.session.commit()
            message = 'Category {:d} was deleted.'.format(id)
            response_status = status.HTTP_200_OK
        except DatabaseException as e:
            db.session.rollback()
            message = str(e)
            response_status = status.HTTP_500_INTERNAL_SERVER_ERROR
    else:
        message = 'Category {:d} is not found.'.format(id)
        response_status = status.HTTP_404_NOT_FOUND
    return make_response(jsonify({
        'message': message,
    }), response_status)


@controllers.route('/categories/<int:id>', methods=['PUT'])
def update_category(id):
    """
    Update category's info by its id. (U in CRUD pattern)

    :param id: category id
    :type  id: int

    :return: response with info
    :rtype:  flask.wrappers.Response
    """
    category = Category.query.get(id)
    if category is not None:
        try:
            category.save(request.json)
            db.session.commit()
            message = 'Category {:d} was updated.'.format(id)
            response_status = status.HTTP_200_OK
        except DatabaseException as e:
            db.session.rollback()
            message = str(e)
            response_status = status.HTTP_500_INTERNAL_SERVER_ERROR
    else:
        message = 'Category {:d} is not found.'.format(id)
        response_status = status.HTTP_404_NOT_FOUND
    return make_response(jsonify({
        'message': message,
        'category': category.to_dict(),
    }), response_status)


@controllers.route('/categories/', methods=['POST'])
def create_category():
    """
    Create category. (C in CRUD pattern)

    :return: response with info
    :rtype:  flask.wrappers.Response
    """
    category = Category()
    try:
        category.save(request.json)
        db.session.add(category)
        db.session.commit()
        message = 'Category {:d} was created.'.format(category.id)
        response_status = status.HTTP_201_CREATED
    except DatabaseException as e:
        db.session.rollback()
        message = str(e)
        response_status = status.HTTP_500_INTERNAL_SERVER_ERROR
    return make_response(jsonify({
        'message': message,
        'category': category.to_dict(),
    }), response_status)
