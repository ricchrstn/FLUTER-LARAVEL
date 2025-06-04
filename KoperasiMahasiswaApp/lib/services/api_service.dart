import 'package:dio/dio.dart';

class ApiService {
  final String _baseUrl = "http://10.0.2.2:8000/api"; // For Android emulator
  // final String _baseUrl = "http://localhost:8000/api"; // For iOS simulator
  final Dio _dio = Dio();

  // Constructor
  ApiService() {
    _dio.options.connectTimeout = const Duration(seconds: 5);
    _dio.options.receiveTimeout = const Duration(seconds: 3);
  }

  // Authentication Methods
  Future<Response> login(String email, String password) async {
    try {
      return await _dio.post(
        '$_baseUrl/login',
        data: {'email': email, 'password': password},
      );
    } catch (e) {
      rethrow;
    }
  }

  Future<Response> register(
    String name,
    String email,
    String password,
    String nim,
    String phone,
  ) async {
    try {
      return await _dio.post(
        '$_baseUrl/register',
        data: {
          'name': name,
          'email': email,
          'password': password,
          'nim': nim,
          'phone': phone,
        },
      );
    } catch (e) {
      rethrow;
    }
  }

  Future<Response> logout(String token) async {
    try {
      return await _dio.post(
        '$_baseUrl/logout',
        options: Options(headers: {'Authorization': 'Bearer $token'}),
      );
    } catch (e) {
      rethrow;
    }
  }

  // Anggota (Member) Methods
  Future<Response> getAnggota(String token) async {
    try {
      return await _dio.get(
        '$_baseUrl/anggota',
        options: Options(headers: {'Authorization': 'Bearer $token'}),
      );
    } catch (e) {
      rethrow;
    }
  }

  Future<Response> createAnggota(
    String token,
    Map<String, dynamic> data,
  ) async {
    try {
      return await _dio.post(
        '$_baseUrl/anggota',
        data: data,
        options: Options(headers: {'Authorization': 'Bearer $token'}),
      );
    } catch (e) {
      rethrow;
    }
  }

  // Simpanan (Savings) Methods
  Future<Response> getSimpanan(String token) async {
    try {
      return await _dio.get(
        '$_baseUrl/simpanan',
        options: Options(headers: {'Authorization': 'Bearer $token'}),
      );
    } catch (e) {
      rethrow;
    }
  }

  Future<Response> createSimpanan(
    String token,
    Map<String, dynamic> data,
  ) async {
    try {
      return await _dio.post(
        '$_baseUrl/simpanan',
        data: data,
        options: Options(headers: {'Authorization': 'Bearer $token'}),
      );
    } catch (e) {
      rethrow;
    }
  }

  // Get User Profile
  Future<Response> getUserProfile(String token) async {
    try {
      return await _dio.get(
        '$_baseUrl/user',
        options: Options(headers: {'Authorization': 'Bearer $token'}),
      );
    } catch (e) {
      rethrow;
    }
  }
}
